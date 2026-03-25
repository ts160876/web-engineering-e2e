<?php

namespace Bukubuku\Models;

use Bukubuku\Core\Model;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

class RegistrationModel extends Model
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    protected function getRulesets(): array
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
                Rule::EMAIL => []
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

    public function register(): string
    {
        return "Handling registration.";
    }
}
