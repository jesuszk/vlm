<?php

namespace src\repositories;

use PDO;
use src\database\Database;


class ProductRepository extends Querio
{
    protected string $table = 'products';
    public PDO $db;
    function __construct()
    {
        $this->db = Database::local();
    }

    function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
