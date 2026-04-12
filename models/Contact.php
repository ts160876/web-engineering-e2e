<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Models;

use Bukubuku\Core\Model;
use Bukubuku\Core\Rule;

/**
 * Implements the model for contact requests.
 */
class Contact extends Model
{
    //Properties of the model
    public string $subject = '';
    public string $email = '';
    public string $message = '';

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

    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'subject' => 'Subject',
            'email' => 'E-Mail',
            'message' => 'Message',
        ];
    }

    //Process the contact request. Currently this does nothing.
    public function process(): bool
    {
        return true;
    }
}
