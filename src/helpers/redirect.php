<?php

use src\core\Route;

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

        if (substr_count($r['uri'], '{') !== count($indexes)) {
            preg_match_all('/\{(.*?)\}/', $r['uri'], $matches);
            $keys = implode(', ', array_map(fn($item) => '{' . $item . '}', $matches[1]));
            throw new Exception('route.missing.parameters: ' . $keys, 500);
        }


        if (str_contains($r['uri'], '{')) {
            preg_match_all('/\{(.*?)\}/', $r['uri'], $matches);
            $keys = implode(', ', array_map(fn($item) => '{' . $item . '}', $matches[1]));

            foreach ($indexes as $key => $value) {
                if (!str_contains($r['uri'], '{' . $key . '}'))
                    throw new Exception("route.missing.parameters: {$keys} " . '<br> passed: {' . $key . '} not found', 500);
                $r['uri'] = str_replace('{' . $key . '}', $value, $r['uri']);
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
            if (isset($route['name']) && $route['name'] === $name) {
                return ['uri' => $uri, 'info' => $route];
            }
        }
    }
    return null;
}


function redirect()
{
    return new class {
        private string $uri;
        function back()
        {
            $r =  new RedirectBack();
            $this->uri = $r->uri;
            return $r;
        }

        function uri(string $uri)
        {
            $r =  new RedirectUri($uri);
            $this->uri = $r->uri;
            return $r;
        }

        function route(string $name, array $indexes = [])
        {
            $r =  new RedirectRoute($name, $indexes);
            $this->uri = $r->uri;
            return $r;
        }
    };
}



class RedirectHeader
{
    public ?string $uri;

    function make()
    {
        header('Location: ' . $this->uri);
    }
}


class RedirectUri extends RedirectHeader
{
    public ?string $uri;
    function __construct(string $uri)
    {
        $this->uri = $uri;
    }
}




class RedirectBack extends RedirectHeader
{
    public ?string $uri;
    function __construct()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->uri = $_SERVER['HTTP_REFERER'];
        } else
            $this->uri = '';
    }
}


class RedirectRoute extends RedirectHeader
{
    public ?string $uri;
    function __construct(string $name, array $indexes)
    {

        $r = findUriByName(Route::routes(), $name);
        if ($r) {

            if (substr_count($r['uri'], '{') !== count($indexes))
                throw new Exception('route.missing.parameters ' . $name, 500);

            if (str_contains($r['uri'], '{')) {
                foreach ($indexes as $key => $index) {
                    $r['uri'] = str_replace('{' . $key . '}', $index, $r['uri']);
                }
            }
        }


        if (!$r)
            throw new Exception('Não foi possível encontrar uma rota com o nome: ' . $name);
        $this->uri = $r['uri'];
    }
}
