<?php

use src\core\Route;

/**
 * Its responsible for redirect for another link/url
 *
 * @param string $to
 * @return void
 */
function redirect(string $to)
{
    header("Location: {$to}");
    exit;
}


/**
 * Its responsible for joining uri with base url from app
 *
 * @param string $route
 * @return string
 */
function route(string $routeName, array $indexes = [])
{
    $r = findUriByName(Route::routes(), $routeName);

    if ($r) {
        if (str_contains($r['uri'], '{')) {
            foreach ($indexes as $key => $index) {
                $r['uri'] = str_replace('{' . $key . '}', $index, $r['uri']);
            }
        }
    }


    if (!$r)
        throw new Exception('Não foi possível encontrar uma rota com o nome: ' . $routeName);
    return $r['uri'];
}


function findUriByName(array $routes, string $name)
{
    foreach ($routes as $method => $routeGroup) {
        foreach ($routeGroup as $uri => $route) {
            // Verifica se o índice 'name' existe e se o valor corresponde
            if (isset($route['name']) && $route['name'] === $name) {
                return ['uri' => $uri, 'info' => $route];
            }
        }
    }
    return null;
}

/**
 * Its responsible for return to last url
 *
 * @return string
 */
function url_back()
{
    if (isset($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
    return '#';
}
