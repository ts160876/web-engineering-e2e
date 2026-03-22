<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Controller;

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
        return $this->renderView('registration');
    }

    public function handleRegistration(): string
    {
        return 'Handling registration.';
    }
}
