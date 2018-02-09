<?php

namespace Libs;

class Router {

    protected static $routes = [];
    protected static $default = [];
    protected static $error404 = [];

    public function setRouteArray(array $routes): void
    {

        if (empty(self::$routes)) {
            $output = [];
            foreach ($routes['routes'] AS $key => $route) {
                $output[$this->trimRoute($key)] = $route;
            }
        
            if (!isset($routes['default'])) {
                throw new \Exception('Nincs default route beállítva!');
            }

            if (!isset($routes['error404'])) {
                throw new \Exception('Nincs error route beállítva!');
            }

            self::$routes = $output;
            self::$default = $routes['default'];
            self::$error404 = $routes['error404'];
        }
    }

    public function resolve(string $uri): array
    {
        $uri = $this->trimRoute($uri);

        dd(self::$routes);



        if ($uri === '') {
            return self::$default;
        }

        foreach (self::$routes AS $key => $route) {
            if ($route['uri']===$uri) {
                return array_merge(['key'=>$key], $route);
            }
        }

        return self::$error404;
    }

    protected function trimRoute(string $route): string
    {
        $route = str_replace('index.php','', $route);

        $route = explode('?', $route);
        $route = $route[0];

        return trim(trim($route),'/');
    }

}