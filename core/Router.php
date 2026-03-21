<?php

namespace Bukubuku\Core;

class Router
{
    private Request $request;
    private array $routes;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function register(string $requestMethod, string $path, callable|array $action)
    {
        $this->routes[$requestMethod][$path] = $action;
    }

    public function registerGet(string $path, callable|array $action)
    {
        $this->register('GET', $path, $action);
    }

    public function registerPost(string $path, callable|array $action)
    {
        $this->register('POST', $path, $action);
    }

    public function resolve()
    {
        //Determine the action for the given request method and path.
        $requestMethod = $this->request->getRequestMethod();
        $path = $this->request->getPath();
        $action = $this->routes[$requestMethod][$path] ?? null;

        //Call the action, if it could be determined. Otherwise show 'Not found'.
        if ($action !== null) {
            echo call_user_func($action);
        } else {
            echo 'Not found';
        }
    }
}
