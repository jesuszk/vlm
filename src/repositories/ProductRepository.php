<?php

namespace src\repositories;

use PDO;
use src\database\Database;


class ProductRepository extends Querio
{
    protected string $table = 'products';

    function find(int $id): array|bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
