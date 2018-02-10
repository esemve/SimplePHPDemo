<?php

namespace Libs;

interface ViewInterface
{
    /**
     * Template kirenderelése.
     *
     * @param string $template
     * @param array $params
     */
    public function render(string $template, array $params = []): string;
}