<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class View represents a view. It ensures that the view from the /views folder is rendered 
 * properly and adheres to the layout of the application.
 */
class View
{
    /*Currently the layout to be used is hardcoded. Additional layouts could be added. In this case
    the render method would need an additional parameter to pass the layout. */
    private const LAYOUT = '/views/layouts/main.php';

    //Attributes of the view
    public string $title = '';

    //Render the view.
    public function render(string $view, array $parameters = []): string
    {
        $viewContent = $this->getViewContent($view, $parameters);
        $layoutContent = $this->getLayoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    //Get the layout content of the view.
    private function getLayoutContent(): string
    {
        //Start output buffering.
        ob_start();

        include_once Application::$app->rootDirectory . VIEW::LAYOUT;

        //Return the content from the buffer and clear the buffer.
        return ob_get_clean();
    }

    /*Get the content of the view. Al parameters passed to the method will
    be made available to the view.*/
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
