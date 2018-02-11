<?php

namespace Libs;

use Libs\Exceptions\FileNotFoundException;

class View implements ViewInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
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

        require $path;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}