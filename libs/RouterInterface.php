<?php

namespace Libs;

interface RouterInterface
{
    /**
     * Egy tömbből beállítja a route -okat.
     * Csak egyszer hívható
     *
     * @param array $routes
     */
    public function setRouteArray(array $routes): void;

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