<?php

use src\core\Bootstrap;


ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);

require_once __DIR__ . "/vendor/autoload.php";

initSessionIfNotStarted();
loadEnv();


Bootstrap::run();
