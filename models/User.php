<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

/**
 * Implements the model for the user.
 */
class User extends DatabaseModel
{
    //Properties of the model
    public int $userId = 0;
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    //The UI needs a second field to confirm the password.
    public string $confirmPassword = '';
    //The database needs to store the password hash.
    public string $hashedPassword = '';
    //And a boolean is treated as TINYINT by MySQL.
    public int $isAdmin = 0;

    //Get database table.
    static protected function getTableName(): string
    {
        return 'users';
    }

    //Get the primary key of the database table.
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
            'pwd' => 'hashedPassword',
            'is_admin' => 'isAdmin',
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
                //To allow easier testing, we allow very short passwords.
                Rule::MIN_LENGTH => [RuleParameter::MIN => 3],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'confirmPassword' => [
                Rule::REQUIRED => [],
                Rule::MATCH => [RuleParameter::MATCH => 'password']
            ]
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
            'isAdmin' => 'User Role'
        ];
    }

    //Check the login based on email and password.
    static public function checkLogin(string $email, string $password): bool
    {
        $userId = User::getUserIdByEmail($email);
        if ($userId != 0) {
            $user = User::fromDatabase($userId);
            return $user->checkPassword($password);
        } else {
            return false;
        }
    }

    //Get dropdown values for isAdmin.
    static public function getIsAdminDropdown(): array
    {
        return [
            0 => 'Customer',
            1 => 'Administrator'
        ];
    }

    //Get text for isAdmin.
    static public function getIsAdminText(int $isAdmin): string
    {
        $dropdown = static::getIsAdminDropdown();
        return $dropdown[$isAdmin] ?? $isAdmin;
    }

    //Get a user by the email.
    static public function getUserIdByEmail(string $email): int
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

    //Verify the password.
    public function checkPassword($password): bool
    {
        if (password_verify($password, $this->hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    //Get the fullname. 
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    //Insert the instance of the model into the database.
    public function insert(): bool
    {
        //We need to hash the password.
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }

    //Register the use (just a wrapper for insert).
    public function register(): bool
    {
        return $this->insert();
    }

    //Update the instance of the model in the database.
    public function update(array $properties = []): bool
    {
        //We need to hash the password.
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::update($properties);
    }
}
