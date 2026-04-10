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
        $user = User::fromHttp(Application::$app->getFlashMemory(User::class) ?? []);
        return $this->renderView('registration', ['model' => $user]);
    }

    public function handleRegistration(): string|null
    {
        //Get the data from the (POST) request.
        $user = User::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($user->validateData() == true) {
            if ($user->register() == true) {
                //Registration was successful. 
                Application::$app->setFlashSuccessMessage('You have successfully registered.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Registration as not successful.
                Application::$app->setFlashErrorMessage('Your registration failed.');
                //Redirect back to the form.
                Application::$app->response->redirect('/registration');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(User::class, $user->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect('/registration');
            return null;
        }
    }

    public function list(): string
    {
        $users = User::getAll();
        return $this->renderView('users/list', ['users' => $users]);
    }

    public function page(): string
    {
        $page = Application::$app->request->getParameter('page') ?? 1;
        $users = User::getAll($page);
        return $this->renderView('users/page', ['users' => $users, 'page' => $page]);
    }
}
