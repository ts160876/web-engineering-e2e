<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Application;
use Bukubuku\Core\Controller;
use Bukubuku\Models\Checkout;
use Bukubuku\Core\exception\InternalErrorException;

class CheckoutController extends Controller
{
    public function create(): string
    {
        $checkout = Checkout::fromHttp(Application::$app->getFlashMemory(Checkout::class) ?? []);
        return $this->renderView('/checkouts/create', ['model' => $checkout]);
    }

    public function handleCreate(): string|null
    {
        //Get the data from the (POST) request.
        $checkout = Checkout::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($checkout->validateData() == true) {
            if ($checkout->insert() == true) {
                //Creation was successful. 
                Application::$app->setFlashSuccessMessage('You have successfully create the checkout.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Registration as not successful.
                Application::$app->setFlashErrorMessage('The checkout creation failed.');
                //Redirect back to the form.
                Application::$app->response->redirect('/checkouts/create');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(Checkout::class, $checkout->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect('/checkouts/create');
            return null;
        }
    }

    public function edit(): string
    {
        if (Application::$app->getFlashMemory(Checkout::class) != null) {
            $checkout = Checkout::fromHttp(Application::$app->getFlashMemory(Checkout::class));
        } else {
            $checkoutId = Application::$app->request->getParameter('checkoutId');
            if ($checkoutId != null) {
                $checkout = Checkout::fromDatabase($checkoutId);
            } else {
                throw new InternalErrorException();
            }
        }
        return $this->renderView('/checkouts/edit', ['model' => $checkout]);
    }

    public function handleEdit(): string|null
    {
        //Get the data from the (POST) request.
        $checkout = Checkout::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($checkout->validateData() == true) {
            if ($checkout->update() == true) {
                //Creation was successful. 
                Application::$app->setFlashSuccessMessage('You have successfully updated the checkout.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Registration as not successful.
                Application::$app->setFlashErrorMessage('The checkout update failed.');
                //Redirect back to the form.
                Application::$app->response->redirect('/checkouts/edit');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(Checkout::class, $checkout->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect("/checkouts/edit?bookId=$checkout->bookId");
            return null;
        }
    }

    public function list(): string
    {
        $checkouts = Checkout::getAll();
        return $this->renderView('checkouts/list', ['checkouts' => $checkouts]);
    }

    public function page(): string
    {
        $page = Application::$app->request->getParameter('page') ?? 1;
        $checkouts = Checkout::getAll($page);
        return $this->renderView('checkouts/page', ['checkouts' => $checkouts, 'page' => $page]);
    }

    public function return(): string
    {
        return '';
    }

    public function handleReturn(): string|null
    {
        return null;
    }
}
