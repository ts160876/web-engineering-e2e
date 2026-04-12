<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class Rule represents the different rules which can be validated by the model(s).
 * Currently, it consists of a constant for each supported rule and of methods to construct
 * error messages for each rule.
 */
class Rule
{
    public const REQUIRED = 'required';
    public const MIN_LENGTH = 'minLength';
    public const MAX_LENGTH = 'maxLength';
    public const UNIQUE = 'unique';
    public const EXISTS = 'exists';
    public const EMAIL = 'email';
    public const NUMBER = 'number';
    public const MATCH = 'match';
    public const OPTIONS = 'options';
    public const ISBN = 'isbn';

    //Construct error message.
    static public function constructErrorMessage(string $propertyName, string $propertyLabel, string $ruleName, array $parameters): string
    {
        $errorMessage = Rule::getErrorMessage($ruleName);

        //If the property name is not part of the parameters, we add it here.
        if (!array_key_exists(RuleParameter::PROPERTY, $parameters)) {
            $parameters[RuleParameter::PROPERTY] = $propertyName;
        }

        //We do the same for the label.
        if (!array_key_exists(RuleParameter::LABEL, $parameters)) {
            $parameters[RuleParameter::LABEL] = $propertyLabel;
        }

        foreach ($parameters as $parameterName => $parameterValue) {
            $errorMessage = str_replace('{{' . $parameterName . '}}', strval($parameterValue), $errorMessage);
        }
        return $errorMessage;
    }

    /*For each rule there is a corresponding error message. 
    The error message can have placeholders in the format {{placeholder}}.*/
    static private function getErrorMessage(string $ruleName): string
    {
        switch ($ruleName) {
            case Rule::REQUIRED:
                return 'The field {{label}} is required.';
            case Rule::MIN_LENGTH;
                return 'The minimum lenth for field {{label}} is {{min}}.';
            case Rule::MAX_LENGTH;
                return 'The maximum lenth for field {{label}} is {{max}}.';
            case Rule::UNIQUE:
                return 'The value in field {{label}} does already exist.';
            case Rule::EXISTS:
                return 'The value in field {{label}} does not exist.';
            case Rule::EMAIL:
                return 'The field {{label}} must be a valid e-mail.';
            case Rule::NUMBER:
                return 'The field {{label}} must be a valid number.';
            case Rule::MATCH:
                return 'The field {{label}} must match {{match}}.';
            case Rule::OPTIONS:
                return 'The value in field {{label}} is not allowed.';
            case Rule::ISBN:
                return 'The value in field {{label}} is not a valid ISBN (xxx-xxxxxxxxxx).';
            default:
                return 'There is a severe error.';
        }
    }
}
