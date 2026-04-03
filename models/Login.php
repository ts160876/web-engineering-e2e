<?php

namespace Bukubuku\Models;

use Bukubuku\Core\Model;
use Bukubuku\Core\Rule;

class Login extends Model
{

    public int $userId = 0;
    public string $email = '';
    public string $password = '';

    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'userId' => 'User ID',
            'email' => 'E-Mail',
            'password' => 'Password',
        ];
    }

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [
            'email' => [
                Rule::REQUIRED => [],
                Rule::EMAIL => []
            ],
            'password' => [
                Rule::REQUIRED => [],
            ]
        ];
    }

    //Pseudo implementation.
    protected function isUnique(string $property): bool
    {
        return true;
    }

    //Login user.
    public function login(): bool
    {
        if (User::checkLogin($this->email, $this->password)) {
            $this->userId = User::getUserIdByEmail($this->email);
            return true;
        } else {
            $this->userId = 0;
            return false;
        }
    }

    //Logout user.
    public function logout(): bool
    {
        //There are not preconditions to be fulfilled to logout.
        //Hence the function always returns true;
        $this->userId = 0;
        $this->email = '';
        $this->password = '';
        return true;
    }
}
