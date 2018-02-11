<?php

namespace App\Controller;

use DI\Container;
use Libs\Request;
use Libs\Response\JsonResponse;
use Libs\Response\RedirectResponse;
use Libs\Response\Response;
use Libs\Response\ResponseFactoryInterface;
use Libs\ViewInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Request
     */
    private $request;

    final public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    final protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    final public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    final protected function getRequest(): Request
    {
        return $this->request;
    }

    final protected function render(string $template, array $params = []): Response
    {
        return $this->createStringResponse(
            $this->getViewRenderer()->render($template, $params)
        );
    }

    protected function getViewRenderer(): ViewInterface
    {
        return $this->getContainer()->get('libs.view');
    }

    public function error404(): Response
    {
        $response = $this->render('error/404.html.php');
        $response->setStatusCode(404);

        return $response;
    }

    final public function createRedirectResponse(string $url): RedirectResponse
    {
        return $this->getResponseFactory()->createRedirectResponse($url);
    }

    final protected function createJsonResponse(array $content): JsonResponse
    {
        return $this->getResponseFactory()->createJsonResponse($content);
    }

    final protected function createStringResponse(string $content): Response
    {
        return $this->getResponseFactory()->createResponse($content);
    }

    protected function getResponseFactory(): ResponseFactoryInterface
    {
        return $this->getContainer()->get('libs.response.factory');
    }


}