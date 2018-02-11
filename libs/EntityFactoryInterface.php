<?php

namespace Libs;

interface EntityFactoryInterface
{
    /**
     * Kapott entitynév alapján visszaad egy példányt belőle
     *
     * @param string $entityClass
     * @return AbstractEntity
     */
    public function create(string $entityClass): AbstractEntity;
}