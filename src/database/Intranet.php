<?php

namespace src\database;

class Intranet extends Database
{
    function __construct()
    {
        require $_ENV['INTRANET_CURRENT'];
        $this->typeConnection = 'mysql';
        $this->host = $mysql_hostname;
        $this->dbname = $mysql_database;
        $this->username = $mysql_username;
        $this->password = $mysql_password;
    }
}
