<?php

namespace Bukubuku\Models;

use Bukubuku\Core\Model;
use Bukubuku\Core\Rule;

class Contact extends Model
{

    public string $subject = '';
    public string $email = '';
    public string $message = '';

    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'subject' => 'Subject',
            'email' => 'E-Mail',
            'message' => 'Message',
        ];
    }

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [
            'subject' => [
                Rule::REQUIRED => [],
            ],
            'email' => [
                Rule::REQUIRED => [],
                Rule::EMAIL => []
            ],
            'message' => [
                Rule::REQUIRED => [],
            ]
        ];
    }

    //Pseudo implementation.
    protected function isUnique(string $property): bool
    {
        return true;
    }

    //Process the contact request.
    public function process(): bool
    {
        return true;
    }
}
