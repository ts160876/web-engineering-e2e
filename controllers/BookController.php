<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Application;
use Bukubuku\Core\Controller;
use Bukubuku\Models\Book;
use Bukubuku\Models\BookCheckout;
use Bukubuku\Core\exception\InternalErrorException;

class BookController extends Controller
{

    public function create(): string
    {
        $book = Book::fromHttp(Application::$app->getFlashMemory(Book::class) ?? []);
        return $this->renderView('/books/create', ['model' => $book]);
    }

    public function handleCreate(): string|null
    {
        //Get the data from the (POST) request.
        $book = Book::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($book->validateData() == true) {
            if ($book->insert() == true) {
                //Creation was successful. 
                Application::$app->setFlashSuccessMessage('You have successfully create the book.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Registration as not successful.
                Application::$app->setFlashErrorMessage('The book creation failed.');
                //Redirect back to the form.
                Application::$app->response->redirect('/books/create');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(Book::class, $book->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect('/books/create');
            return null;
        }
    }

    public function edit(): string
    {
        if (Application::$app->getFlashMemory(Book::class) != null) {
            $book = Book::fromHttp(Application::$app->getFlashMemory(Book::class));
        } else {
            $bookId = Application::$app->request->getParameter('bookId');
            if ($bookId != null) {
                $book = Book::fromDatabase($bookId);
            } else {
                throw new InternalErrorException();
            }
        }
        return $this->renderView('/books/edit', ['model' => $book]);
    }

    public function handleEdit(): string|null
    {
        //Get the data from the (POST) request.
        $book = Book::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data.
        if ($book->validateData() == true) {
            if ($book->update() == true) {
                //Creation was successful. 
                Application::$app->setFlashSuccessMessage('You have successfully updated the book.');
                //Redirect to home.
                Application::$app->response->redirect('/');
                return null;
            } else {
                //Registration as not successful.
                Application::$app->setFlashErrorMessage('The book update failed.');
                //Redirect back to the form.
                Application::$app->response->redirect('/books/edit');
                return null;
            }
        } else {
            //Validation has errors.
            Application::$app->setFlashErrorMessage('The form has errors. Please correct them.');
            Application::$app->setFlashMemory(Book::class, $book->toHttp());
            //Redirect back to the form.
            Application::$app->response->redirect("/books/edit?bookId=$book->bookId");
            return null;
        }
    }

    public function list(): string
    {
        $books = Book::getAll();
        return $this->renderView('books/list', ['books' => $books]);
    }

    public function page(): string
    {
        $page = Application::$app->request->getParameter('page') ?? 1;
        $books = Book::getAll($page, 5);
        return $this->renderView('books/page', ['books' => $books, 'page' => $page]);
    }

    public function checkout(): string
    {
        if (Application::$app->getFlashMemory(BookCheckout::class) != null) {
            $bookCheckout = BookCheckout::fromHttp(Application::$app->getFlashMemory(BookCheckout::class));
        } else {
            if (Application::$app->isCustomer() == true) {
                $userId = Application::$app->getUserId();
                $bookId = Application::$app->request->getParameter('bookId');
                if ($userId != null && $bookId != null) {
                    $bookCheckout = BookCheckout::prepareCheckout($userId, $bookId);
                } else {
                    throw new InternalErrorException();
                }
            } else {
                throw new InternalErrorException();
            }
        }
        return $this->renderView('books/checkout', ['model' => $bookCheckout]);
    }

    public function handleCheckout(): string|null
    {
        //Get the data from the (POST) request.
        $bookCheckout = BookCheckOut::fromHttp(
            ['properties' => Application::$app->request->getParameters()]
        );

        //Validate the data. We keep this a bit simple here, since all fields are readonly.
        if ($bookCheckout->checkoutBook() == true) {
            //Checkout was successful. 
            Application::$app->setFlashSuccessMessage('You have successfully checked out.');
            //Redirect to home.
            Application::$app->response->redirect('/');
            return null;
        } else {
            //Registration as not successful.
            Application::$app->setFlashErrorMessage('Your checkout failed.');
            //Redirect to home.
            Application::$app->response->redirect('/');
            return null;
        }
    }
}
