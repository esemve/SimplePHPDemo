<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Libs\Exceptions\NotFoundException;
use Libs\Response\Response;

class IndexController extends AbstractController {

    public function index(): Response
    {
        return $this->render('index.html.php',[
            'posts' => $this->getBlogRepository()->findAll()
        ]);
    }

    public function show(string $id = "0"): Response
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

    protected function getBlogRepository(): BlogRepository
    {
        return $this->getContainer()->get('app.repository.blog');
    }
}