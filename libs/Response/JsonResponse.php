<?php

namespace Libs\Response;

class JsonResponse extends AbstractResponse implements ResponseInterface
{
    protected $content = [];

    public function setContent(array $content = []): JsonResponse
    {
        $this->content = $content;

        return $this;
    }

    public function sendResponse(): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->content);
    }
}