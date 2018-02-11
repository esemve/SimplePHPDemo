<?php

namespace Libs;

use Libs\Exceptions\FileNotFoundException;

class View implements ViewInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;
    /**
     * @var Request
     */
    private $request;

    public function __construct(RouterInterface $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    public function render(string $file, array $parameters = []): string
    {
        $path = __DIR__.'/../views/'.$file;

        if (false === file_exists($path)) {
            throw new FileNotFoundException();
        }

        ob_start();
        extract($parameters);

        $router = $this->router;
        $request = $this->request;

        require $path;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}