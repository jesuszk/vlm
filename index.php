<?php
require_once __DIR__ . "/vendor/autoload.php";

initSessionIfNotStarted();
$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();
src\core\Bootstrap::do();
