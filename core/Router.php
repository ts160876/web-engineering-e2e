<?php

namespace Bukubuku\Core;

use Bukubuku\Core\exception\NotAuthorizedException;
use Bukubuku\Core\exception\NotFoundException;

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

        //Check the user authorization.
        if (!Application::$app->isAuthorized($path)) {
            throw new NotAuthorizedException();
        }

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
                return (new View())->render($action);
            }
        } else {
            throw new NotFoundException();
        }
    }
}
