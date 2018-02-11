<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Repository\BlogRepository;
use Libs\Exceptions\NotFoundException;
use Libs\Response\ResponseInterface;

class IndexController extends AbstractController {

    public function index(): ResponseInterface
    {
        return $this->render('index.html.php',[
            'posts' => $this->getBlogRepository()->findAll()
        ]);
    }

    public function show(string $id): ResponseInterface
    {
        $id = (int) $id;

        try {
            $post = $this->getBlogRepository()->findById($id);
        } catch (NotFoundException $ex) {
            return $this->error404();
        }

        return $this->render('show.html.php',[
            'post' => $post
        ]);
    }

    public function create(): ResponseInterface
    {
        /**
         * @var BlogPost $entity
         */
        $entity = $this->getBlogRepository()->createNewEntity();

        if ($this->isValidPost()) {
            $entity = $this->getBlogRepository()->save(
                $this->fillEntityFromRequest($entity)
            );
            if ($entity->getId()) {
                return $this->createRedirectResponse('/');
            }
        }

        return $this->render('create.html.php',[
            'entity' => $entity,
        ]);
    }

    public function edit(string $id): ResponseInterface
    {
        $id = (int) $id;

        /**
         * @var BlogPost $entity
         */
        $entity = $this->getBlogRepository()->findById($id);

        if ($this->isValidPost()) {
            $this->getBlogRepository()->save(
                $this->fillEntityFromRequest($entity)
            );

            return $this->createRedirectResponse('/');
        }

        return $this->render('edit.html.php',[
            'entity' => $entity,
        ]);
    }

    protected function getBlogRepository(): BlogRepository
    {
        return $this->getContainer()->get('app.repository.blog');
    }

    protected function isValidPost(): bool
    {
        return ($this->getRequest()->isPost() && $this->getRequest()->isValidCsrf() && (!empty($this->getRequest()->get('title'))));
    }

    private function fillEntityFromRequest(BlogPost $entity): BlogPost
    {
        $entity->setTitle($this->getRequest()->get('title'));
        $entity->setLead($this->getRequest()->get('lead'));
        $entity->setContent($this->getRequest()->get('content'));

        return $entity;
    }
}