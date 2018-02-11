<?php

namespace Libs\Response;

interface ResponseFactoryInterface {

    public function createRedirectResponse(string $url): RedirectResponse;

    public function createJsonResponse(array $content): JsonResponse;

    public function createResponse(string $content): Response;

}