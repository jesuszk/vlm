<?php






function initSessionIfNotStarted(): void
{
    if (session_status() === PHP_SESSION_NONE)
        @session_start();
}



function loadEnv(): void
{
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__ . "/../..");
    $dotenv->load();
}
