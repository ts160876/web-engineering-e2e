<?php

namespace Bukubuku\Core;

class View
{

    public string $title = '';

    public function render(string $view, array $parameters = []): string
    {
        $viewContent = $this->getViewContent($view, $parameters);
        $layoutContent = $this->getLayoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function getLayoutContent(): string
    {
        //Start output buffering.
        ob_start();
        include_once Application::$app->rootDirectory . '/views/layouts/main.php';
        //Return the content from the buffer and clear the buffer.
        return ob_get_clean();
    }

    private function getViewContent(string $view, array $parameters = []): string
    {
        //Start output buffering.
        ob_start();

        //Make the parameters passed to this method available to the view.
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }

        include_once Application::$app->rootDirectory . '/views/' . $view . '.php';
        //Return the content from the buffer and clear the buffer.
        return ob_get_clean();
    }
}
