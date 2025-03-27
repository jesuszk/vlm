<?php

namespace src\core;

use Exception;
use src\support\Uri;
use src\support\View;

class Bootstrap
{

    public static function start(): void
    {
        try {
            $r = (new Router)->get();
            if (!$r)
                throw new Exception("route.unavailable", 500);
            Middleware::execute($r['middlewares']);
            (new Controller(explode(":", implode('@', $r['action']))[0]));
        } catch (Exception $e) {
            $message = $e->getMessage();
            $r = View::render('templates.error', ['mssg' => $message, 'code' => $e->getCode()]);
            echo $r::$isString;
        }
    }
}
