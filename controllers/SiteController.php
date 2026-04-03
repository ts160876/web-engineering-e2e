<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Application;
use Bukubuku\Core\Controller;
use Bukubuku\Models\Login;

class SiteController extends Controller
{
    public function home(): string
    {
        $parameters = ['name' => 'BukuBuku'];
        return $this->renderView('home', $parameters);
    }

    public function contact(): string
    {
        return $this->renderView('contact');
    }

    public function handleContact(): string
    {
        return 'Processing your contact request.';
    }

    public function login(): string
    {

        $login = Login::fromHttp(Application::$app->getFlashMemory(Login::class) ?? []);
        return $this->renderView('login', ['model' => $login]);
    }

    public function handleLogin(): string|null
    {
        //Get the data from the (POST) request.
        $login = Login::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($login->validateData() == true) {
            if ($login->login() == true) {
                //Login was successful. 
                Application::$app->login($login->userId);
                Application::$app->setFlashSuccessMessage('You have successfully logged in.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Login was not successful.
                Application::$app->setFlashErrorMessage('Your login failed.');
                //Redirect to login.
                Application::$app->response->redirect('/login');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(Login::class, $login->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect('/login');
            return null;
        }
    }

    public function profile(): string
    {
        return $this->renderView('profile');
    }

    public function handleLogout(): string|null
    {
        //Logout, i.e. remove the user from the session.
        Application::$app->logout();
        Application::$app->setFlashSuccessMessage('You have successfully logged out.');
        //Redirect to home.
        Application::$app->response->redirect('/');
        return null;
    }
}
