<?php

namespace Libs\Response;

class Response extends AbstractResponse implements ResponseInterface
{
    protected $content;

    public function setContent(string $content): Response
    {
        $this->content = $content;
        return $this;
    }

    public function sendResponse(): void
    {
        echo $this->content;
    }
}