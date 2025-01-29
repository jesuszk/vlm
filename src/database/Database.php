<?php

namespace src\database;

use Exception;
use PDO;
use PDOException;


class Database
{
    protected ?PDO $pdo = null;
    protected ?string $typeConnection = null;
    protected ?string $host = null;
    protected ?string $dbname = null;
    protected ?string $username = null;
    protected ?string $password = null;
    protected ?string $service = null;
    protected ?string $server = null;


    function get()
    {
        return $this->connect();
    }

    /**
     * Method performs the database connection
     * @return PDO
     */
    protected function connect(): PDO
    {
        try {
            $this->pdo = new PDO($this->getDsn(), $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            dd("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Obtains the type of DNS according to the informed connection
     * 
     * @return string
     */
    protected function getDsn(): string
    {
        switch ($this->typeConnection) {
            case 'mysql':
                return "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4";
            case 'sqlserver':
                return "sqlsrv:Server=" . $this->host . ";Database=" . $this->dbname . "";
            case 'informix':
                return "informix:host=" . $this->host . "; service=" . $this->service . "; database=" . $this->dbname . "; server=" . $this->server . "; protocol=olsoctcp";
            default:
                throw new Exception("Tipo de conexão inválido: " . $this->typeConnection . "");
        }
    }
}