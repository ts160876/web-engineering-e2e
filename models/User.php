<?php

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;
use PDOStatement;

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
    static protected function getTableName(): string
    {
        return 'users';
    }
    //Get the primary key of the database table (assumption: one column).
    static protected function getPrimaryKeyName(): string
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

    public function checkPassword($password): bool
    {
        if ($this->password == $password) {
            return true;
        } else {
            return false;
        }
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public static function getUserIdByEmail(string $email): int
    {
        //Create SQL statement
        $query = "SELECT user_id FROM users WHERE email = :email;";
        $statement = static::prepare($query);
        //Bind the parameter and execute the statement.
        //$statement->bindValue();
        $statement->execute([':email' => $email]);
        $x = $statement->fetchColumn();
        return $x;
    }

    public static function checkLogin(string $email, string $password): bool
    {
        $userId = User::getUserIdByEmail($email);
        if ($userId != 0) {
            $user = User::fromDatabase($userId);
            return $user->checkPassword($password);
        } else {
            return false;
        }
    }
}
