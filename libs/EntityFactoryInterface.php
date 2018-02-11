<?php

namespace Libs;

interface EntityFactoryInterface
{
    public function create(string $entityClass): AbstractEntity;
}