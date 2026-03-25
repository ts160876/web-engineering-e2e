<?php

namespace Bukubuku\Core;

//This represents the different rules which can be validated by the model(s).
class Rule
{
    public const REQUIRED = 'required';
    public const MIN_LENGTH = 'minLength';
    public const MAX_LENGTH = 'maxLength';
    public const UNIQUE = 'unique';
    public const EMAIL = 'email';
    public const NUMBER = 'number';
    public const MATCH = 'match';

    static public function constructErrorMessage(string $propertyName, string $ruleName, array $parameters): string
    {
        $errorMessage = Rule::getErrorMessage($ruleName);

        //If the property name is not part of the parameters, we add it here.
        if (!array_key_exists(RuleParameter::PROPERTY, $parameters)) {
            $parameters[RuleParameter::PROPERTY] = $propertyName;
        }

        foreach ($parameters as $parameterName => $parameterValue) {
            $errorMessage = str_replace('{{' . $parameterName . '}}', $parameterValue, $errorMessage);
        }
        return $errorMessage;
    }

    //For each rule there is a corresponding error message. 
    //The error message can have placeholders
    static private function getErrorMessage(string $ruleName): string
    {
        switch ($ruleName) {
            case Rule::REQUIRED:
                return 'The field {{property}} is required.';
            case Rule::MIN_LENGTH;
                return 'The minimum lenth for field {{property}} is {{min}}.';
            case Rule::MAX_LENGTH;
                return 'The maximum lenth for field {{property}} is {{max}}.';
            case Rule::UNIQUE:
                return 'The value in field {{property}} does already exist.';
            case Rule::EMAIL:
                return 'The field {{property}} must be a valid e-mail.';
            case Rule::NUMBER:
                return 'The field {{property}} must be a valid number.';
            case Rule::MATCH:
                return 'The field {{property}} must match {{match}}.';
            default:
                return 'There is a severe error.';
        }
    }
}
