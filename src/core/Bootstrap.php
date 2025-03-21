<?php

namespace src\core;

use Exception;

class Bootstrap
{

    public static function run(): void
    {
        try {
            $r = (new Router)->get();
            if (!$r)
                throw new Exception("A rota informada não está disponível", 500);

            self::executeMiddlewares($r['middlewares']);
            (new Controller(self::getOnlyClassAndMethod(implode('@', $r['action']))));
        } catch (Exception $e) {
            dd("Error ({$e->getCode()}):" . $e->getMessage());
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
