<?php

namespace Libs;

final class Request
{
    protected $params;

    protected $type;

    protected $csrf;

    public function __construct()
    {
        if (null !== $this->params) {
            throw new \Exception('A request object csak egyszer jöhet létre!');
        }

        $this->initCsrf();

        $this->params = $_REQUEST;
        $this->type = $_SERVER['REQUEST_METHOD'];

        unset($_REQUEST);
        unset($_POST);
        unset($_GET);
    }

    public function get(string $key, ?string $default = null): ?string
    {
        if (!isset($this->params[$key])) {
            return $default;
        }

        return $this->params[$key];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isPost(): string
    {
        if ($this->getType()==='POST') {
            return true;
        }

        return false;
    }

    public function isValidCsrf(): bool
    {
        if ($this->get('csrf_token') === $this->csrf) {
            return true;
        }

        return false;
    }

    public function getCsrf(): string
    {
        return $this->csrf;
    }

    protected function initCsrf(): void
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = md5(json_encode($_SERVER,true));
        }

        $this->csrf = $_SESSION['csrf'];
    }
}