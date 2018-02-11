<?php

namespace Libs;

interface RouterInterface
{
    /**
     * Egy tömbből beállítja a route -okat.
     * Csak egyszer hívható
     *
     * @param array $routes
     * @return RouterInterface
     */
    public function setRouteArray(array $routes): RouterInterface;

    /**
     * Kapott uri -ra megnézi, hogy matchel-e valamelyik
     * route, majd visszaadja a matchet a paraméterekkel
     * és a kulcs nevével együtt.
     *
     * @param string $uri
     * @return array
     */
    public function resolve(string $uri): array;


}