<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

/**
 * Implements the model for the checkout.
 */
class Checkout extends DatabaseModel
{
    //Properties of the model
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

    //Get the primary key of the database table.
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

    //Read all records from the database for a given user.
    static public function getUserCheckouts(int $userId, int $page = 0, int $limit = 10): array
    {
        $tableName = static::getTableName();
        $columnNames = static::getColumnNames();
        $columnsWithAlias = array_map(fn($columnName) => static::addAlias($columnName), $columnNames);

        //Create SQL statement.
        $query = 'SELECT ' . implode(', ', $columnsWithAlias)  . ' FROM ' . $tableName . ' WHERE user_id = :user_id ';
        if ($page != 0) {
            $query = $query . ' LIMIT :limit OFFSET :offset;';
            $offset = ($page - 1) * $limit;
        } else {
            $query = $query . ';';
        }

        $statement = static::prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        if ($page != 0) {
            $statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        }
        $statement->execute();

        return $statement->fetchAll();
    }
}
