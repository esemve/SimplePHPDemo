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
        $this->type = $_SERVER['REQUEST_METHOD'] ?? null;

        unset($_REQUEST);
        unset($_POST);
        unset($_GET);
    }

    /**
     * A requestből kulcs alapján egy értéket ad vissza.
     *
     * @param string $key
     * @param mixed $default Ha nem található a kulcs akkor ezt adja vissza
     * @return null|string
     */
    public function get(string $key, ?string $default = null): ?string
    {
        if (!isset($this->params[$key])) {
            return $default;
        }

        return $this->params[$key];
    }

    /**
     * Visszaadja, hogy a request GET|POST|PUT... tipusu
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Visszaadja, hogy POST típusú-e a request
     *
     * @return string
     */
    public function isPost(): string
    {
        if ($this->getType()==='POST') {
            return true;
        }

        return false;
    }

    /**
     * A post requesthez csatolva van-e a csrf_token field, és az
     * valid-e?
     *
     * @return bool
     */
    public function isValidCsrf(): bool
    {
        if ($this->get('csrf_token') === $this->csrf) {
            return true;
        }

        return false;
    }

    /**
     * Visszaadja a CSRF token értékét
     *
     * @return string
     */
    public function getCsrf(): string
    {
        return $this->csrf;
    }

    /**
     * Beállít egy CSRF tokent önmagában és a sessionban
     */
    protected function initCsrf(): void
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = md5(json_encode($_SERVER,true));
        }

        $this->csrf = $_SESSION['csrf'];
    }
}