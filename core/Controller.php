<?php

namespace Bukubuku\Core;

class Controller
{
    public function renderView($view, $parameters = []): string
    {
        return Application::$app->router->renderView($view, $parameters);
    }
}
