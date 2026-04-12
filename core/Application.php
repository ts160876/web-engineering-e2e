<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

use Bukubuku\Models\User;

/**
 * The class Application represents the overall web application.
 */
class Application
{
    /*This property stores the instances to the application itself. This allows to instantiate the 
    application once at the beginning of the HTTP request and access it from everywhere via the static
    * property.*/
    static public Application $app;

    public Request $request;
    public Response $response;
    public Session $session;
    public Router $router;
    public Database $db;

    //Root directory
    public string $rootDirectory;
    //Array with the authorizations for the three roles (i.e., admin, customer, guest).
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

    //Run the application, i.e. resolve the HTTP request.
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {
            $this->response->setResponseCode($exception->getCode());
            echo (new View())->render('error', ['exception' => $exception]);
        }
    }

    //Login the user.
    public function login(int $userId)
    {
        $this->session->set('userId', $userId);
    }

    //Logout the user.
    public function logout()
    {
        $this->session->unset('userId');
    }

    //Get the ID of the (logged in) user.
    public function getUserId(): int|null
    {
        return $this->session->get('userId');
    }

    //Is the user a guest?
    public function isGuest(): bool
    {
        if ($this->getUserId() == null) {
            return true;
        } else {
            return false;
        }
    }

    //Is the user an administrator?
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

    //Is the user a customer?
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

    //Get the full name of the (logged in) user.
    public function getFullName(): string
    {
        if (!$this->isGuest()) {
            $user = User::fromDatabase(Application::$app->getUserId());
            return $user->getFullName() . ', ' . $this->getRole();
        } else {
            return '';
        }
    }

    //Get the role of the user.
    private function getRole(): string
    {
        if ($this->isAdmin()) {
            $role = 'admin';
        } elseif ($this->isCustomer()) {
            $role = 'customer';
        } else {
            $role = 'guest';
        }
        return $role;
    }

    //Is the user authorized for the path?
    public function isAuthorized(string $path): bool
    {
        //Determine the user role.
        $role = $this->getRole();
        $script = $this->request->getScriptName();

        $allowedPaths = $this->authorizations[$role];
        if (in_array($path, $allowedPaths)) {
            return true;
        } else {
            return false;
        }
    }

    //Determine the complete URL based on the path.
    public function pathToUrl(string $path): string
    {
        return $this->request->getScriptName() . $path;
    }

    //Write to the flash memory (encapsulates session).
    public function setFlashMemory($key, $value)
    {
        $this->session->setFlashMemory($key, $value);
    }

    //Read from the flash memory (encapsulates session).
    public function getFlashMemory($key)
    {
        return $this->session->getFlashMemory($key);
    }

    //Write a success message to the flash memory.
    public function setFlashSuccessMessage(string $message)
    {
        $this->session->setFlashMemory('success', $message);
    }

    //Read the success message from the flash memory.
    public function getFlashSuccessMessage(): string
    {
        return $this->session->getFlashMemory('success');
    }

    //Write an error message to the flash memory.
    public function setFlashErrorMessage(string $message)
    {
        $this->session->setFlashMemory('error', $message);
    }

    //Read the error message from the flash memory.
    public function getFlashErrorMessage(): string
    {
        return $this->session->getFlashMemory('error');
    }

    //Get cover path.
    public function getCoverPath(string $isbn): string|bool
    {
        //That is a bit of a hack and should be done differently for productive usage.
        if (!$this->doesCoverExist($isbn)) {
            $isbn = '999-9999999999';
        }

        return substr($this->request->getScriptName(), 0, strlen($this->request->getScriptName()) - strlen('index.php')) . 'covers/' . $isbn . '.jpg';
    }

    //Check if cover exists.
    private function doesCoverExist(string $isbn): string|bool
    {
        //This is a bit of a hack and should be done differently for productive usage.
        $coverFile = $this->rootDirectory . '\\public\\covers\\' . $isbn . '.jpg';
        return file_exists($coverFile);
    }
}
