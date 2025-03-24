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
}
