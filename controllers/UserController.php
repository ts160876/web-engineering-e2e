<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Application;
use Bukubuku\Core\Controller;
use Bukubuku\Models\User;

class UserController extends Controller
{
    public function login(): string
    {
        return $this->renderView('login');
    }

    public function handleLogin(): string
    {
        return 'Handling login.';
    }

    public function registration(): string
    {
        $flashMemory = Application::$app->session->getFlashMemory(User::class) ?? [];
        $properties = $flashMemory['properties'] ?? [];
        $errors = $flashMemory['errors'] ?? [];
        $registrationModel = User::fromHttp($properties, $errors);
        return $this->renderView('registration', ['model' => $registrationModel]);
    }

    public function handleRegistration(): string|null
    {
        //$registrationModel = new RegistrationModel();
        $registrationModel = User::fromHttp(Application::$app->request->getParameters());
        if ($registrationModel->validateData() == true) {
            if ($registrationModel->register() == true) {
                Application::$app->session->setFlashMemory('success', 'You have successfully registered.');
            } else {
                Application::$app->session->setFlashMemory('success', 'Your registration failed.');
            }

            Application::$app->response->redirect('/web-engineering-e2e/public/index.php/');
            return null;
        } else {
            //For now we return the view once more. 
            Application::$app->session->setFlashMemory('error', 'The form has errors. Please correct them.');
            Application::$app->session->setFlashMemory(User::class, $registrationModel->toHttp());
            Application::$app->response->redirect('/web-engineering-e2e/public/index.php/registration');
            return null;
        }
    }

    public function list(): string
    {
        $users = User::getAll();
        return $this->renderView('users/list', ['users' => $users]);
    }
}
