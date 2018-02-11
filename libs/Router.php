<?php

namespace Libs;

class Router implements RouterInterface
{
    protected $routes = [];
    protected $default = [];
    protected $error404 = [];

    /**
     * Beállítja egy tömb alapján az összes route -ot amivel
     * később képes dolgozni
     *
     * @param array $routes
     * @return RouterInterface
     * @throws \Exception
     */
    public function setRoutes(array $routes): RouterInterface
    {
        if (empty($this->routes)) {
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

            $this->routes = $output;
            $this->default = $routes['default'];
            $this->error404 = $routes['error404'];
        }

        return $this;
    }

    /**
     * Egy uri alapján visszaadja annak a route -nak az adatait
     * amire illesztkedik
     *
     * @param string $uri
     * @return array
     */
    public function resolve(string $uri): array
    {
        $uri = $this->getTrimmedUri($uri);

        if ($uri === '') {
            return array_merge(['key'=>'default'],$this->default);
        }

        $explodedUri = $this->getExplodedUri($uri);

        foreach ($this->routes AS $key => $route) {
            if (true === $this->isMatch($explodedUri, $route['uri'])) {
                return array_merge([
                    'key' => $key,
                    'parameters' => $this->getUrlParams($explodedUri, $route['uri'])
                ], $route);
            }
        }

        return array_merge(['key'=>'error404'], $this->error404);
    }

    /**
     * A kapott exploded uri illesztkedik-e egy adott route -ra
     *
     * @param array $explodedUri
     * @param string $route
     * @return bool
     */
    protected function isMatch(array $explodedUri, string $route): bool
    {
        $explodedRoute = $this->getExplodedUri($this->getTrimmedUri($route));
        $explodedUriPartCount = count($explodedUri);
        $pass = 0;

        /**
         * @todo Nem kötelező párok kidolgozása {?name}
         * @todo Olyan kulcs=érték párok amik nem az url-be szerepelnek (?valami=ize)
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

    /**
     * Trimmeli az url-t, és leveszi a felesleges részeket belőle
     *
     * @param string $route
     * @return string
     */
    protected function getTrimmedUri(string $route): string
    {
        $route = str_replace('index.php','', $route);

        $route = explode('?', $route);
        $route = $route[0];

        return trim(trim($route),'/');
    }

    /**
     * Explodeol egy uri -t
     *
     * @param string $uri
     * @return array
     */
    protected function getExplodedUri(string $uri): array
    {
        return explode('/', $uri);
    }

    /**
     * Visszaadja egy exploded uri alapjan, hogy milyen
     * url paraméterek tartoznak az url-hez
     *
     * @param array $explodedUri
     * @param string $route
     * @return array
     */
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

    /**
     * Route név alapján kigenerál egy string url -t
     *
     * @param string $routeName
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function getUrl(string $routeName = 'default', array $params = []): string
    {
        if ($routeName==='default') {
            return '/';
        }

        if (!isset($this->routes[$routeName])) {
            throw new \Exception(
                sprintf('Nincs %s nevű route key!', $routeName)
            );
        }

        /**
         * @todo Nem kötelező párok kidolgozása
         * @todo Olyan kulcs=érték párok amik nem az url-be szerepelnek (?valami=ize)
         */

        $route = $this->routes[$routeName]['uri'];
        foreach ($params as $key => $value) {
            $route = str_replace('{'.$key.'}',$value, $route);
        }

        return $route;
    }

}