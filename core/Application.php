<?php

namespace Bukubuku\Core;

class Application
{
    public static Application $app;

    public Request $request;
    public Response $response;
    public Session $session;
    public Router $router;
    public Database $db;
    public string $rootDirectory;

    public function __construct(string $dsn, string $username, string $password, string $rootDirectory)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router();
        $this->db = new Database($dsn, $username, $password);
        $this->rootDirectory = $rootDirectory;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
