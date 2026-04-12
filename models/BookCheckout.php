<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Models;

use Bukubuku\Core\Application;
use Bukubuku\Core\Model;
use Bukubuku\Core\exception\InternalErrorException;

/**
 * Implements the model for the checkout.
 * Background: When checking out a book, we need a transaction around the database
 * operations for the book and the checkout. 
 */
class BookCheckout extends Model
{
    //Properties of the model
    public int $checkoutId = 0;
    public int $userId = 0;
    public string $firstName = '';
    public string $lastName = '';
    public int $bookId = 0;
    public string $title = '';
    public string $author = '';
    public string $isbn = '';
    public ?\DateTime $published = null;
    public int $pages = 0;
    public string $format = '';

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [];
    }

    //Pseudo implementation.
    protected function isUnique(string $property): bool
    {
        return true;
    }

    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'checkoutId' => 'Checkout ID',
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'bookId' => 'Book ID',
            'title' => 'Title',
            'author' => 'Author',
            'isbn' => 'ISBN',
            'published' => 'Published on',
            'pages' => 'Number of Pages',
            'format' => 'Format'
        ];
    }

    //Prepare checkout.
    static public function prepareCheckout(int $userId, int $bookId)
    {
        $user = User::fromDatabase($userId);
        $book = Book::fromDatabase($bookId);
        if ($user->userId != null && $book->bookId != null) {
            $userProperties = $user->toHttp()['properties'];
            $bookProperties = $book->toHttp()['properties'];
            //We assume that there are no properties with the same names.
            $properties = array_merge($userProperties, $bookProperties);
            return new static($properties);
        } else {
            throw new InternalErrorException();
        }
    }

    //Checkout book (quick & dirty implementation).
    public function checkoutBook(): bool
    {
        $user = User::fromDatabase($this->userId);
        $book = Book::fromDatabase($this->bookId);
        if ($user->userId != null && $book->bookId != null && $book->checkoutStatus != 'checked_out') {
            $book->checkoutStatus = 'checked_out';

            $checkout = Checkout::fromHttp(['properties' => [
                'userId' => $user->userId,
                'bookId' => $book->bookId,
                'startTime' => new \DateTime()
            ]]);

            Application::$app->db->beginTransaction();
            if ($book->update() == true) {
                if ($checkout->insert() == true) {
                    Application::$app->db->commit();
                    return true;
                } else {
                    Application::$app->db->rollback();
                    return false;
                }
            } else {
                Application::$app->db->rollback();
                return false;
            }
        } else {
            throw new InternalErrorException();
        }
    }

    //Prepare return.
    static public function prepareReturn(int $checkoutId)
    {
        $checkout = Checkout::fromDatabase($checkoutId);
        $user = User::fromDatabase($checkout->userId);
        $book = Book::fromDatabase($checkout->bookId);
        if ($checkout->checkoutId != null && $user->userId != null && $book->bookId != null) {
            $checkoutProperties = $checkout->toHttp()['properties'];
            $userProperties = $user->toHttp()['properties'];
            $bookProperties = $book->toHttp()['properties'];
            //We assume that there are no properties with the same names.
            $properties = array_merge($checkoutProperties, $userProperties, $bookProperties);
            return new static($properties);
        } else {
            throw new InternalErrorException();
        }
    }

    //Return book (quick & dirty implementation).
    public function returnBook(): bool
    {
        $checkout = Checkout::fromDatabase($this->checkoutId);
        $user = User::fromDatabase($this->userId);
        $book = Book::fromDatabase($this->bookId);
        if (
            $checkout->checkoutId != null && $checkout->endTime == null &&
            $user->userId != null &&
            $book->bookId != null && $book->checkoutStatus == 'checked_out'
        ) {
            $book->checkoutStatus = 'available';
            $checkout->endTime = new \DateTime();

            Application::$app->db->beginTransaction();
            if ($book->update() == true) {
                if ($checkout->update() == true) {
                    Application::$app->db->commit();
                    return true;
                } else {
                    Application::$app->db->rollback();
                    return false;
                }
            } else {
                Application::$app->db->rollback();
                return false;
            }
        } else {
            throw new InternalErrorException();
        }
    }
}
