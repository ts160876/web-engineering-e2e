<?php

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

class User extends DatabaseModel
{

    public int $userId = 0;
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    //A boolean is treated as TINYINT by MySQL.
    public int $isAdmin = 0;

    //Get database table.
    static protected function getTable(): string
    {
        return 'users';
    }
    //Get the primary key of the database table (assumption: one column).
    static protected function getPrimaryKey(): string
    {
        return 'user_id';
    }
    //Get the mapping column=>property.
    static protected function columnMapping(): array
    {
        return [
            'user_id' => 'userId',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'email' => 'email',
            'pwd' => 'password',
            'is_admin' => 'isAdmin',
        ];
    }
    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'E-Mail',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'isAdmin' => 'Is Administrator'
        ];
    }

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [
            'firstName' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'lastName' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'email' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100],
                Rule::EMAIL => [],
                Rule::UNIQUE => []
            ],
            'password' => [
                Rule::REQUIRED => [],
                Rule::MIN_LENGTH => [RuleParameter::MIN => 10],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'confirmPassword' => [
                Rule::REQUIRED => [],
                Rule::MATCH => [RuleParameter::MATCH => 'password']
            ]
        ];
    }

    public function register(): bool
    {
        return $this->insert();
    }
}
