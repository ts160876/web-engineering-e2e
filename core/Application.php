<?php

namespace Bukubuku\Core;

use Bukubuku\Models\User;

class Application
{
    public static Application $app;

    public Request $request;
    public Response $response;
    public Session $session;
    public Router $router;
    public Database $db;
    public string $rootDirectory;
    public array $authorizations;

    public function __construct(string $dsn, string $username, string $password, string $rootDirectory, array $authorizations)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router();
        $this->db = new Database($dsn, $username, $password);
        $this->rootDirectory = $rootDirectory;
        $this->authorizations = $authorizations;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {
            $this->response->setResponseCode($exception->getCode());
            echo (new View())->render('error', ['exception' => $exception]);
        }
    }

    public function login(int $userId)
    {
        $this->session->set('userId', $userId);
    }

    public function logout()
    {
        $this->session->unset('userId');
    }

    public function getUserId(): int|null
    {
        return $this->session->get('userId');
    }

    public function isGuest(): bool
    {
        if ($this->getUserId() == null) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin(): bool
    {
        if (!$this->isGuest()) {
            $user = User::fromDatabase(Application::$app->getUserId());
            if ($user->isAdmin == true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function isCustomer(): bool
    {
        if (!$this->isGuest()) {
            $user = User::fromDatabase(Application::$app->getUserId());
            if ($user->isAdmin == false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getFullName(): string
    {
        if (!$this->isGuest()) {
            $user = User::fromDatabase(Application::$app->getUserId());
            return $user->getFullName();
        } else {
            return '';
        }
    }

    public function isAuthorized(string $path): bool
    {
        //Determine the user role.
        if ($this->isAdmin()) {
            $role = 'admin';
        } elseif ($this->isCustomer()) {
            $role = 'customer';
        } else {
            $role = 'guest';
        }

        $allowedPaths = $this->authorizations[$role];
        if (in_array($path, $allowedPaths)) {
            return true;
        } else {
            return false;
        }
    }

    //Set and get flash memory.
    public function setFlashMemory($key, $value)
    {
        $this->session->setFlashMemory($key, $value);
    }

    public function getFlashMemory($key)
    {
        return $this->session->getFlashMemory($key);
    }

    //Set and get success flash message.
    public function setFlashSuccessMessage(string $message)
    {
        $this->session->setFlashMemory('success', $message);
    }
    public function getFlashSuccessMessage(): string
    {
        return $this->session->getFlashMemory('success');
    }

    //Set and get success flash message.
    public function setFlashErrorMessage(string $message)
    {
        $this->session->setFlashMemory('error', $message);
    }
    public function getFlashErrorMessage(): string
    {
        return $this->session->getFlashMemory('error');
    }
}
