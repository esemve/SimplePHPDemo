<?php

namespace Libs;

use Libs\Exceptions\FileNotFoundException;

class View implements ViewInterface
{
    public function render(string $file, array $parameters = []): string
    {
        $path = __DIR__.'/../views/'.$file;

        if (false === file_exists($path)) {
            throw new FileNotFoundException();
        }

        ob_start();
        extract($parameters);

        require $path;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}