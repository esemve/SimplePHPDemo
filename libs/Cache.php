<?php

namespace Libs;

use Predis\ClientInterface;

class Cache implements CacheInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $prefix;

    public function setPrefix(string $prefix): CacheInterface
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function setClient(ClientInterface $client): CacheInterface
    {
        $this->client = $client;

        return $this;
    }

    public function set(string $key, string $value, ?int $ttl = 3600): void
    {
        $this->client->setex($this->prefix.$key, $ttl, $value);
    }

    public function get(string $key): ?string
    {
        return $this->client->get($this->prefix.$key);
    }

    public function keys(string $pattern): array
    {
        return $this->client->keys($this->prefix.$pattern);
    }

    public function del(array $keys): string
    {
        $keyList = [];
        foreach ($keys AS $key) {
            $keyList[] = $this->prefix.$key;
        }

        return $this->client->del($keyList);
    }

    public function flushByPrefix(string $keyPrefix): void
    {
        $keys = $this->keys($keyPrefix.':*');
        if (!empty($keys)) {
            $this->client->del($keys);
        }
    }

    public function flushAll(): void
    {
        $keys = $this->keys('*');
        if (!empty($keys)) {
            $this->client->del($keys);
        }
    }

}