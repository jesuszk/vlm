<?php

namespace src\core;

use Exception;
use src\support\Uri;
use src\support\View;

class Bootstrap
{

    public static function run(): void
    {
        try {
            $r = (new Router)->get();
            if (!$r) {
                $uri = Uri::get();
                throw new Exception("route.unavailable", 500);
            }

            self::executeMiddlewares($r['middlewares']);
            (new Controller(self::getOnlyClassAndMethod(implode('@', $r['action']))));
        } catch (Exception $e) {
            $message = $e->getMessage();
            $r = View::render('templates.error', ['mssg' => $message, 'code' => $e->getCode()]);
            echo $r::$isString;
        }
    }


    private static function getOnlyClassAndMethod(string $router): string
    {
        [$classAndMethod] = explode(":", $router);
        return $classAndMethod;
    }


    private static function executeMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            new $middleware();
        }
    }
}
