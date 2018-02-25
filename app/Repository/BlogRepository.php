<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Libs\AbstractEntity;
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

    public function findById(int $id): AbstractEntity
    {
        $cacheKey = 'blogpost:'.$id;
        $post = $this->getCache()->get($cacheKey);

        if (!empty($post)) {
            return unserialize($post);
        }

        $post = parent::findById($id);
        $this->getCache()->set($cacheKey, serialize($post), 3600);

        return $post;
    }

    public function findAll(string $orderBy = 'id', string $order = 'DESC'): array
    {
        $cacheKey = 'blogposts:'.$orderBy.':'.$order;
        $posts = $this->getCache()->get($cacheKey);

        if ($posts) {
            return unserialize($posts);
        }

        $posts = parent::findAll($orderBy, $order);

        $this->getCache()->set($cacheKey, serialize($posts));
        return $posts;
    }

    public function insert(AbstractEntity $entity): AbstractEntity
    {
        $this->flushConnectedCache();
        return parent::insert($entity);
    }

    public function update(AbstractEntity $entity): AbstractEntity
    {
        $this->flushConnectedCache();
        $this->getCache()->del(['blogpost:'.$entity->getId()]);
        return parent::update($entity);
    }

    protected function flushConnectedCache(): void
    {
        $this->getCache()->flushByPrefix('blogposts');
    }
}