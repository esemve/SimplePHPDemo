<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Libs\AbstractRepository;

class BlogRepository extends AbstractRepository
{
    protected function getEntityClass(): string
    {
        return BlogPost::class;
    }

    protected function getTable(): string
    {
        return 'blog';
    }
}