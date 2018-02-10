<?php

namespace App\Controller;

use Libs\Response\Response;

class ErrorController extends AbstractController
{
    public function error404(): Response
    {
        $response = $this->render('error/404.html.php');
        $response->setStatusCode(404);

        return $response;
    }

    public function error500(\Exception $ex): Response
    {
        $response = $this->render('error/500.html.php',['exception' => $ex]);
        $response->setStatusCode(500);

        return $response;
    }
}