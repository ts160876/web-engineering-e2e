<?php

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

class Checkout extends DatabaseModel
{

    public int $checkoutId = 0;
    public int $userId = 0;
    public int $bookId = 0;
    public ?\DateTime $startTime = null;
    public ?\DateTime $endTime = null;

    //Get database table.
    static protected function getTableName(): string
    {
        return 'checkouts';
    }
    //Get the primary key of the database table (assumption: one column).
    static protected function getPrimaryKeyName(): string
    {
        return 'checkout_id';
    }
    //Get the mapping column=>property.
    static protected function columnMapping(): array
    {
        return [
            'checkout_id' => 'checkoutId',
            'user_id' => 'userId',
            'book_id' => 'bookId',
            'start_time' => 'startTime',
            'end_time' => 'endTime'
        ];
    }
    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'checkoutId' => 'Checkout ID',
            'userId' => 'User ID',
            'bookId' => 'Book ID',
            'startTime' => 'Start Time',
            'endTime' => 'End Time',
        ];
    }

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [
            'userId' => [
                Rule::REQUIRED => [],
                Rule::EXISTS => [RuleParameter::CLASSNAME => User::class]
            ],
            'bookId' => [
                Rule::REQUIRED => [],
                Rule::EXISTS => [RuleParameter::CLASSNAME => Book::class]

            ],
            'startTime' => [
                Rule::REQUIRED => [],
            ],
        ];
    }
}
