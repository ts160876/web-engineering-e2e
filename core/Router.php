<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

use Bukubuku\Core\exception\NotAuthorizedException;
use Bukubuku\Core\exception\NotFoundException;

/**
 * The class Router handles HTTP requests which have been registered with it. 
 * The basic usage pattern is:
 * Step 1: Register paths and the corresponding action via registerGet and registerPost.
 * Step 2: Determine the action to be executed based on the method and path of the HTTP
 * request. This happends in resolve.
 */
class Router
{
    //All routes
    private array $routes;

    //Register the action for a GET request.
    public function registerGet(string $path, callable|array|string $action)
    {
        $this->register('GET', $path, $action);
    }

    //Register the action for a POST request.
    public function registerPost(string $path, callable|array|string $action)
    {
        $this->register('POST', $path, $action);
    }

    //This function is used by registerGet and registerPost internally.
    private function register(string $requestMethod, string $path, callable|array|string $action)
    {
        $this->routes[$requestMethod][$path] = $action;
    }

    //Handle the current HTTP request.
    public function resolve(): string
    {
        //Determine the action for the given request method and path.
        $requestMethod = Application::$app->request->getRequestMethod();
        $path = Application::$app->request->getPath();
        $action = $this->routes[$requestMethod][$path] ?? null;

        //Check the user authorization.
        if (!Application::$app->isAuthorized($path)) {
            //The user it not authorized.
            throw new NotAuthorizedException();
        }

        /*Call the action, if it could be determined. Otherwise show 'Not found'.
        The action can be a callable (i.e., a function) an array (i.e., a class and a method)
        or a string (i.e., a view).*/
        if ($action !== null) {
            if (is_callable($action)) {
                //The action is a callable (i.e., a function).
                return call_user_func($action);
            } elseif (is_array($action)) {
                //The action is an array. We need to instantiate the corresponding controller and call the method.
                [$class, $method] = $action;
                $object = new $class();
                return call_user_func_array([$object, $method], []);
            } else {
                //The action is a string (i.e., a view). Create an instance and directly render this.
                return (new View())->render($action);
            }
        } else {
            //The path is not known and hence no action could be determined.
            throw new NotFoundException();
        }
    }
}
