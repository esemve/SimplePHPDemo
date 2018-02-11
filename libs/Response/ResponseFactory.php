<?php

namespace Libs\Response;

class ResponseFactory implements ResponseFactoryInterface
{
    public function createRedirectResponse(string $url): RedirectResponse
    {
        $response = new RedirectResponse();
        return $response->setContent($url);
    }

    public function createJsonResponse(array $content): JsonResponse
    {
        $response = new JsonResponse();
        return $response->setContent($content);
    }

    public function createResponse(string $content): Response
    {
        $response = new Response();
        return $response->setContent($content);
    }
}