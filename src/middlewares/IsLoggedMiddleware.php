<?php

namespace src\middlewares;


class IsLoggedMiddleware
{
    function execute(): void
    {
        if (!isset($_SESSION['user_id'])) {
           redirect()->route('login')->header();
        }
    }
}
