<?php

namespace Libs;

abstract class AbstractEntity
{
    /**
     * Visszaadja az entity azon paramétereit, melyek
     * a db-ben kerülnek tárolásra
     *
     * @return array
     */
    abstract public function getFieldList(): array;

    /**
     * @var int
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): AbstractEntity
    {
        $this->id = $id;

        return $this;
    }

    public function setFromArray(array $array): AbstractEntity
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function getArray(string $keyPrefix = ''): array
    {
        $output = [];
        foreach ($this->getFieldList() as $value) {
            $output[$keyPrefix.$value] = $this->{$value};
        }

        return $output;
    }
}