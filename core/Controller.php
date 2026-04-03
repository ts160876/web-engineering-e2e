<?php

namespace Bukubuku\Core;

abstract class Controller
{
    public function renderView($view, $parameters = []): string
    {
        //return Application::$app->router->renderView($view, $parameters);
        return (new View())->render($view, $parameters);
    }
}
