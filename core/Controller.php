<?php

namespace Bukubuku\Core;

abstract class Controller
{
    public function renderView($view, $parameters = []): string
    {
        return (new View())->render($view, $parameters);
    }
}
