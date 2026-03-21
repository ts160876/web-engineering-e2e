<?php

namespace Bukubuku\Core;

class Router
{
    private array $routes;

    public function register(string $requestMethod, string $path, $action)
    {
        $this->routes[$requestMethod][$path] = $action;
    }

    public function registerGet(string $path, $action)
    {
        $this->register('GET', $path, $action);
    }

    public function registerPost(string $path, $action)
    {
        $this->register('POST', $path, $action);
    }

    public function resolve(): string
    {
        //Determine the action for the given request method and path.
        $requestMethod = Application::$app->request->getRequestMethod();
        $path = Application::$app->request->getPath();
        $action = $this->routes[$requestMethod][$path] ?? null;

        //Call the action, if it could be determined. Otherwise show 'Not found'.
        if ($action !== null) {
            if (is_callable($action)) {
                return call_user_func($action);
            } else {
                return $this->renderView($action);
            }
        } else {
            Application::$app->response->setResponseCode(404);
            return $this->renderView('404');
        }
    }

    public function renderView(string $view): string
    {
        $layoutContent = $this->getLayoutContent();
        $viewContent = $this->getViewContent($view);

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

    private function getViewContent($view): string
    {
        //Start output buffering.
        ob_start();
        include_once Application::$app->rootDirectory . '/views/' . $view . '.php';
        //Return the content from the buffer and clear the buffer.
        return ob_get_clean();
    }
}
