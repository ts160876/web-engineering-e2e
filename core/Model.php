<?php

namespace Bukubuku\Core;

abstract class Model
{
    private array $errors = [];

    //Load parameters (from HTML forms) into model.
    public function loadParameters(array $parameters)
    {
        //Iterate over all parameters and split them into the name and value of the property.
        foreach ($parameters as $propertyName => $propertyValue) {
            //If a property with the name exists, then we set the value of this property.
            //Otherwise we ignore this parameter.
            if (property_exists($this, $propertyName)) {
                $this->{$propertyName} = $propertyValue;
            }
        }
    }

    //Get the rulesets. This method is implemented in derived models.
    abstract protected function getRulesets(): array;

    //Validate the data currently in the model.
    public function validateData(): bool
    {
        //Reset the error messages at the beginning of the validation.
        $this->errors = [];

        //The rulesets are stored as an associative array where the key is the name of the property to be validated.
        //The value are the rules. The rules are again an associative array.
        //For each rule the key stores the name of the rule. 
        //For each rule the value stores the parameters if applicable (i.e., can be an empty array).
        $rulesets = $this->getRulesets();

        foreach ($rulesets as $propertyName => $rules) {
            $value = $this->{$propertyName};
            foreach ($rules as $ruleName => $parameters) {
                switch ($ruleName) {
                    case Rule::REQUIRED:
                        if (!$value) {
                            $this->addError($propertyName, Rule::REQUIRED, $parameters);
                        }
                        break;
                    case Rule::MIN_LENGTH;
                        if (strlen($value) < $parameters[RuleParameter::MIN]) {
                            $this->addError($propertyName, Rule::MIN_LENGTH, $parameters);
                        }
                        break;
                    case Rule::MAX_LENGTH;
                        if (strlen($value) > $parameters[RuleParameter::MAX]) {
                            $this->addError($propertyName, Rule::MAX_LENGTH, $parameters);
                        }
                        break;
                    case Rule::UNIQUE:
                        //Not yet implemented!
                        break;
                    case Rule::EMAIL:
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($propertyName, Rule::EMAIL, $parameters);
                        }
                        break;
                    case Rule::NUMBER:
                        //Not yet implemented!
                        break;
                    case Rule::MATCH:
                        if ($value !== $this->{$parameters[RuleParameter::MATCH]}) {
                            $this->addError($propertyName, Rule::MATCH, $parameters);
                        }
                        break;
                }
            }
        }

        //Check if errors exist.
        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

    //Add an error to the model.
    private function addError(string $propertyName, string $ruleName, array $parameters)
    {
        $this->errors[$propertyName][] = Rule::constructErrorMessage($propertyName, $ruleName, $parameters);
    }

    //Check if an error exists (for a given property).
    public function hasError(string $propertyName): bool
    {
        if (key_exists($propertyName, $this->errors)) {
            return true;
        } else {
            return false;
        }
    }

    //Get the first error (for a given property).
    public function getFirstError(string $propertyName): string
    {
        if (key_exists($propertyName, $this->errors)) {
            return  $this->errors[$propertyName][0];
        } else {
            return '';
        }
    }
}
