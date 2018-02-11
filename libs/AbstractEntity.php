<?php

namespace Libs;

abstract class AbstractEntity
{
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
}