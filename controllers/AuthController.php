<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Application;
use Bukubuku\Core\Controller;
use Bukubuku\Models\RegistrationModel;

class AuthController extends Controller
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
        $registrationModel = new RegistrationModel();
        return $this->renderView('registration', ['model' => $registrationModel]);
    }

    public function handleRegistration(): string
    {
        $registrationModel = new RegistrationModel();
        $registrationModel->loadParameters(Application::$app->request->getParameters());
        if ($registrationModel->validateData() === true) {
            $registrationModel->register();
            return 'Registration successful.';
        } else {
            //For now we return the view once more. 
            return $this->renderView('registration', ['model' => $registrationModel]);
        }
    }
}
