<?php

namespace Libs\Response;

abstract class AbstractResponse {

    protected $statusCode = 200;

    public function sendStatusCode(): void
    {
        switch ($this->statusCode) {
            case 400:
                header("HTTP/1.1 404 Not Found");
                break;
            case 500:
                header("HTTP/1.1 500 Internal Server Error");
                break;
            default:
                header("HTTP/1.1 200 OK");
                break;
        }
    }

    public function setStatusCode(int $code): void
    {
        $this->statusCode = $code;
    }
}