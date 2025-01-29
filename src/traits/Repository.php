<?php

namespace src\traits;

use PDO;
use Ramsey\Uuid\Rfc4122\UuidV4;
use stdClass;

trait Repository
{
    function configDatabase(PDO $db)
    {
        $this->nexus->db = $db;
        return $this;
    }

}
