<?php

namespace Libs;

use Predis\ClientInterface;

interface CacheInterface
{
    /**
     * Beállítja a kulcsok prefixét
     * @param string $prefix
     */
    public function setPrefix(string $prefix): CacheInterface;

    /**
     * Beállítja a redis cache clientet
     * @param ClientInterface $client
     * @return mixed
     */
    public function setClient(ClientInterface $client): CacheInterface;

    /**
     * Érték tárolása a redisben
     * @param string $key
     * @param string $value
     * @param int|null $ttl
     * @return mixed
     */
    public function set(string $key, string $value, ?int $ttl = 3600);

    /**
     * Érték kikérése a redisből
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string;

    /**
     * Mintára illesztkedő kulcsok listájának lekérdezése
     * @param string $pattern
     * @return string
     */
    public function keys(string $pattern): array;

    /**
     * Tömbben átadva kulcsok amiket törölni szeretnénk
     * @param array $keys
     * @return string
     */
    public function del(array $keys): string;

    /**
     * Kitörli az összes kulcsot aminek köze van a sitehoz
     */
    public function flushAll(): void;

    /**
     * Kulcs előtag alapján törlés
     * @param string $keyPrefix
     */
    public function flushByPrefix(string $keyPrefix): void;

}