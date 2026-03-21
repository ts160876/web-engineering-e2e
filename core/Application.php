<?php

namespace Bukubuku\Core;

class Application
{
    public static Application $app;

    public Request $request;
    public Response $response;
    public Router $router;
    public string $rootDirectory;

    public function __construct(string $rootDirectory)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
        $this->rootDirectory = $rootDirectory;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
