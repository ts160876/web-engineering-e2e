<?php

namespace Bukubuku\Core;

class Router
{
    private array $routes;

    public function register(string $requestMethod, string $path, callable|array|string $action)
    {
        $this->routes[$requestMethod][$path] = $action;
    }

    public function registerGet(string $path, callable|array|string $action)
    {
        $this->register('GET', $path, $action);
    }

    public function registerPost(string $path, callable|array|string $action)
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
                //The action is a callable (i.e., function).
                return call_user_func($action);
            } elseif (is_array($action)) {
                //The action is an array. We need to instantiate the corresponding controller and call the method.
                [$class, $method] = $action;
                $object = new $class();
                return call_user_func_array([$object, $method], []);
            } else {
                //The action is a string (i.e., a view).
                return $this->renderView($action);
            }
        } else {
            Application::$app->response->setResponseCode(404);
            return $this->renderView('404');
        }
    }

    public function renderView(string $view, array $parameters = []): string
    {
        $layoutContent = $this->getLayoutContent();
        $viewContent = $this->getViewContent($view, $parameters);

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
