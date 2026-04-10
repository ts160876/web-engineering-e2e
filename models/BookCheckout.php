<?php

namespace Bukubuku\Models;

use Bukubuku\Core\Model;
use Bukubuku\Core\Rule;

class BookCheckout extends Model
{

    public int $checkoutId = 0;
    public int $bookId = 0;
    public int $userId = 0;


    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [];
    }

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

    //Checkout book.
    public function checkoutBook(): bool
    {
        return true;
    }

    //Return book.
    public function returnBook(): bool
    {
        return true;
    }
}
