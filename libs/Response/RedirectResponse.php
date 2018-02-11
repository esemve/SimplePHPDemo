<?php

namespace Libs\Response;

class RedirectResponse extends AbstractResponse implements ResponseInterface
{
    protected $url = '';

    public function setContent(string $url): RedirectResponse
    {
        $this->url = $url;

        return $this;
    }

    public function sendResponse(): void
    {
        header(sprintf("Location: %s",$this->url));
    }
}