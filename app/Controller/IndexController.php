<?php

namespace App\Controller;

use Libs\Response\Response;

class IndexController extends AbstractController {

    public function index($a = null): Response
    {
        return $this->render('index.html.php',[]);
    }

    public function index2($alma = 0): Response
    {
        return $this->render('index2.html.php',[
            'alma' => $alma
        ]);
    }
}