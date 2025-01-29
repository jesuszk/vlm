<?php

namespace src\middlewares;



class IsLoggedMiddleware
{
    function __construct()
    {
        $this->execute();
    }

    function execute(): bool
    {
        if (!isset($_SESSION['user_id'])) {
        //    redirect("/login");
        }
        return true;
    }
}
