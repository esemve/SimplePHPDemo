<?php

namespace Libs;

class Router implements RouterInterface
{
    protected static $routes = [];
    protected static $default = [];
    protected static $error404 = [];

    public function getRoutes() {
        return self::$routes;
    }

    public function setRouteArray(array $routes): void
    {
        if (empty(self::$routes)) {
            $output = [];
            foreach ($routes['routes'] AS $key => $route) {
                $output[$this->getTrimmedUri($key)] = $route;
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
        $uri = $this->getTrimmedUri($uri);

        if ($uri === '') {
            return self::$default;
        }

        $explodedUri = $this->getExplodedUri($uri);

        foreach (self::$routes AS $key => $route) {
            if (true === $this->isMatch($explodedUri, $route['uri'])) {
                return array_merge([
                    'key' => $key,
                    'parameters' => $this->getUrlParams($explodedUri, $route['uri'])
                ], $route);
            }
        }

        return self::$error404;
    }

    protected function isMatch(array $explodedUri, string $route): bool
    {
        $explodedRoute = $this->getExplodedUri($this->getTrimmedUri($route));
        $explodedUriPartCount = count($explodedUri);
        $pass = 0;

        /**
         * @todo Not required parts!
         */
        if ($explodedUriPartCount===count($explodedRoute)) {
            foreach ($explodedRoute AS $key => $routePart) {
                if (($explodedUri[$key] === $routePart) || ((substr($routePart,0,1)=='{') && (substr($routePart,-1)=='}')))
                {
                    $pass++;
                }
            }
        }

        if ($pass === $explodedUriPartCount) {
            return true;
        }

        return false;
    }

    protected function getTrimmedUri(string $route): string
    {
        $route = str_replace('index.php','', $route);

        $route = explode('?', $route);
        $route = $route[0];

        return trim(trim($route),'/');
    }

    protected function getExplodedUri(string $uri): array
    {
        return explode('/', $uri);
    }

    protected function getUrlParams(array $explodedUri, string $route): array
    {
        $output = [];

        $explodedRoute = $this->getExplodedUri($this->getTrimmedUri($route));
        foreach ($explodedRoute AS $key => $routePart) {
            if ((substr($routePart, 0, 1) == '{') && (substr($routePart, -1) == '}')) {
                $output[str_replace(['{','}'],'', $routePart)] = $explodedUri[$key];
            }
        }

        return $output;
    }

}