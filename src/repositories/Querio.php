<?php

namespace src\repositories;

use Exception;
use PDO;
use PDOException;
use Ramsey\Uuid\Rfc4122\UuidV4;
use src\database\Database;
use src\exceptions\pdo\ColumnDoesntHaveADefaultValueException;
use src\exceptions\pdo\ColumnNotFoundException;
use src\exceptions\pdo\IntegerValueException;
use src\exceptions\pdo\TableOrViewNotFoundException;
use stdClass;

class Querio
{

    public PDO $db;
    protected string $table;
    protected string $queryString;
    /** @var array<string, mixed> */
    protected array $bind;
    protected bool $selectIsOne;


    function __construct()
    {
        $this->set_db(Database::setConfig());
    }

    function set_db(Database $db)
    {
        $this->queryString = '';
        $this->db = $db->get();
        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    function insert(array $data): self
    {
        $this->queryString = "INSERT INTO {$this->table}";
        $this->values($data);
        return $this;
    }

    /**
     * @param array<string, mixed> $binds
     * @return self
     */
    function values(array $binds = []): self
    {
        $this->bind = $binds;
        $keys = implode(", ", array_keys($binds));
        $keysUsingInBind = ":" . implode(", :", array_keys($binds));
        $this->queryString .= " ({$keys}) VALUES ({$keysUsingInBind})";

        return $this;
    }


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function where(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " WHERE {$column} {$operation} :{$columnWithoutTable}";
        $this->bind[$columnWithoutTable] = $value;
        return $this;
    }


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function andWhere(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " AND {$column} {$operation} :{$columnWithoutTable}";
        $this->bind[$columnWithoutTable] = $value;
        return $this;
    }

    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function orWhere(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " OR {$column} {$operation} :{$column}";
        $this->bind[$column] = $value;
        return $this;
    }


    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function andIn(string $column, array $values): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $params = [];
        foreach ($values as $key => $value) {
            $params[":{$column}{$key}"] = $value;
            $this->bind[":{$column}{$key}"] = $value;
        }
        $paramsIn = implode(", ", array_keys($params));

        $this->queryString .= " AND {$column} IN ({$paramsIn})";

        return $this;
    }

    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function whereIn(string $column, array $values): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $params = [];
        foreach ($values as $key => $value) {
            $params[":{$column}{$key}"] = $value;
            $this->bind[":{$column}{$key}"] = $value;
        }
        $paramsIn = implode(", ", array_keys($params));


        $this->queryString .= " WHERE {$column} IN ({$paramsIn})";
        return $this;
    }

    /**
     * @param string $column
     * @return self
     */
    function whereIsNull(string $column): self
    {
        $this->queryString .= " WHERE {$column} IS NULL";
        return $this;
    }

    /**
     * @param string $column
     * @return self
     */
    function whereIsNotNull(string $column): self
    {
        $this->queryString .= " WHERE {$column} IS NOT NULL";
        return $this;
    }

    /**
     * @return object|array<int, object>|bool
     */
    function finish(): object|array|bool
    {
        try {
            $firstWord = strstr($this->queryString, ' ', true);
            if (!is_string($firstWord)) {
                return false;
            }
            $operation = strtolower(trim($firstWord));
            $isSelect = $operation === 'select';

            if (!$isSelect) {
                $stmt = $this->db->prepare($this->queryString);
                $r = $stmt->execute($this->bind ?? []);
                if ($operation === 'insert')
                    return array_merge(['id' => $this->db->lastInsertId()], $this->bind);
                else if ($operation === 'update')
                    return $this->bind;
                return $r;
            } else {
                if ($this->selectIsOne)
                    $this->limit();


                $stmt = $this->db->prepare($this->queryString);
                $stmt->execute($this->bind ?? []);



                $stmt->setFetchMode(PDO::FETCH_OBJ);

                if ($this->selectIsOne) {
                    $found = $stmt->fetch();
                    if (!$found)
                        return false;
                    return $found;
                } else {
                    $found = $stmt->fetchAll();
                    if (!$found)
                        return false;
                    return $found;
                }
            }
        } catch (PDOException $e) {
            
            if (str_contains($e->getMessage(), "doesn't have a default value")) {
                throw new ColumnDoesntHaveADefaultValueException(['message from pdo' => $e->errorInfo[2]]);
            } else if (str_contains($e->getMessage(), 'Base table or view not found')) {
                throw new TableOrViewNotFoundException(['message from pdo' => $e->errorInfo[2]]);
            } else if (str_contains($e->getMessage(), 'Column not found')) {
                throw new ColumnNotFoundException(['message from pdo' => $e->errorInfo[2]]);
            } else if (str_contains($e->getMessage(), 'Incorrect integer value')) {
                throw new IntegerValueException(['message from pdo' => $e->errorInfo[2]]);
            }
            return false;
        }
    }

    /**
     * @param array<int, string> $fields
     * @param bool $selectIsOne - false as default
     */
    function select(array $fields = [], bool $selectIsOne = false): self
    {
        if (empty($fields))
            $fieldsInString = "{$this->table}.*";
        else
            $fieldsInString = implode(', ', $fields);

        $this->selectIsOne = $selectIsOne;
        $this->queryString = "SELECT {$fieldsInString} FROM {$this->table}";
        return $this;
    }


    /**
     * @param array<int, string> $fields
     * @return self
     */
    function selectOne(array $fields = []): self
    {
        return $this->select($fields, true);
    }

    /**
     * @param int $limit - 1 as default
     */
    function limit(int $limit = 1): self
    {
        $this->queryString .= " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function innerJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " INNER JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function leftJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " LEFT JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function rightJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " RIGHT JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function fullJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " FULL OUTER JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }


    /**
     * @param string $table
     * @return self
     */
    function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    function update(array $data): self
    {
        $this->queryString = "UPDATE {$this->table} SET ";
        foreach ($data as $key => $value) {
            $this->queryString .= "{$key} = :{$key}, ";
        }
        $this->queryString = rtrim($this->queryString, ", ");
        $this->bind = $data;
        return $this;
    }



    /**
     * @return self
     */
    function delete(): self
    {
        $this->queryString = "DELETE FROM {$this->table}";
        return $this;
    }

    /**
     * @return self
     */
    function softDelete(): self
    {
        $this->queryString = "UPDATE {$this->table} SET deleted_at = NOW()";
        return $this;
    }

    /**
     * @return ?PDO
     */
    function getPDO(): ?PDO
    {
        return $this->db;
    }

    function transactionBegin(): self
    {
        $this->db->beginTransaction();
        return $this;
    }

    function transactionCommit(): self
    {
        $this->db->commit();
        return $this;
    }

    function transactionRollback(): self
    {
        $this->db->rollback();
        return $this;
    }


    /**
     * @param int $offset
     */
    function offset(int $offset): self
    {
        $this->queryString .= " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param string $column
     * @param string $type
     */
    function order(string $column, string $type): self
    {
        $this->queryString .= " ORDER BY {$column} {$type}";
        return $this;
    }


    function getPagination(int $itemsInPage = 5): stdClass
    {
        $stdclass = new stdClass();

        $raw = $this->finish();
        $pagina = (isset($_GET['page']) ? $_GET['page'] : 1) - 1;
        $offset = $pagina * $itemsInPage;
        $paginated = $this->order("id", "DESC")->limit($itemsInPage)->offset($offset)->finish(0);
        $quantitiesOfPages = ceil(count($raw ? $raw : []) / $itemsInPage);
        $links = pagination($quantitiesOfPages);


        $stdclass->raw = $raw;
        $stdclass->currentPage = $pagina  + 1;
        $stdclass->offset = $offset;
        $stdclass->paginated = $paginated;
        $stdclass->quantitiesOfPages = $quantitiesOfPages;
        $stdclass->quantitiesPerPage = $itemsInPage;
        $stdclass->links = $links;

        return $stdclass;
    }


    // Functions ready for uses

    /**
     * @param array $data
     * @return bool|array<string, mixed>
     */
    function create(array $data): bool|array
    {
        $data['uuid'] = UuidV4::uuid4()->toString();
        return $this->table($this->table)->insert($data)->finish();
    }



    function getById(int $id): stdClass|bool
    {
        return $this->getByColumn("id", $id);
    }

    function getByUuid(string $uuid): stdClass|bool
    {
        return $this->getByColumn("uuid", $uuid);
    }

    function getByColumn(string $column, string $value, string $operation = "="): stdClass|bool
    {
        return $this->table($this->table)->selectOne()->where($column, $operation, $value)->finish();
    }

    /**
     * @param int $id
     * @return bool
     */
    function deleteById(int $id): bool
    {
        return $this->table($this->table)->delete()->where('id', "=", $id)->finish();
    }

    /**
     * @param int $iuud
     * @return bool
     */
    function deleteByUuid(string $uuid): bool
    {
        return $this->table($this->table)->delete()->where('uuid', "=", $uuid)->finish();
    }


    function softDeleteById(int $id): bool
    {
        return $this->table($this->table)->softDelete()->where('id', "=", $id)->finish();
    }

    function softDeleteByUuid(string $uuid): bool
    {
        return $this->table($this->table)->softDelete()->where('uuid', "=", $uuid)->finish();
    }


    function updateById(int $id, array $data)
    {
        return $this->table($this->table)->update($data)->where("id", "=", $id)->finish();
    }

    function updateByUuid(string $uuid, array $data)
    {
        return $this->table($this->table)->update($data)->where("uuid", "=", $uuid)->finish();
    }

    function save()
    {
        if (isset($this->bind['id'])) {
            return $this->updateById($this->bind['id'], $this->bind);
        } else if (isset($this->bind['uuid'])) {
            return $this->updateByUuid($this->bind['uuid'], $this->bind);
        }
        return $this->create($this->bind);
    }

    function getAll(array $fields = ['*']): array
    {
        return $this->table($this->table)->select($fields)->finish();
    }
}
