<?php

namespace Libs;

class EntityFactory implements EntityFactoryInterface
{
    public function create(string $entityClass): AbstractEntity
    {
        return new $entityClass();
    }
}