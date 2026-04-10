<?php

namespace Bukubuku\Core;

abstract class Model
{

    //The following abstract methods have to be implemented in subclasses.
    //Get the mapping property=>label.
    abstract static protected function propertyMapping(): array;
    //Get the rulesets. 
    abstract static protected function getRulesets(): array;
    //Check if property is unique. 
    abstract protected function isUnique(string $property): bool;

    //Get all properties.
    public static function getPropertyNames(): array
    {
        return array_keys(static::propertyMapping());
    }

    //Get the label of a property.
    public static function getLabel($property): string
    {
        return static::propertyMapping()[$property] ?? $property;
    }

    //Load parameters (from HTML form or session) into model.
    public static function fromHttp(array $data)
    {
        return new static($data['properties'] ?? [], $data['errors'] ?? []);
    }

    //Errors collected during validation
    private array $errors = [];

    //Create object (only called via factory methods, hence private).
    protected function __construct(array $properties = [], array $errors = [])
    {
        //Iterate over all parameters and split them into the name and value of the property.
        foreach ($properties as $propertyName => $propertyValue) {
            //If a property with the name exists, then we set the value of this property.
            //Otherwise we ignore this parameter.
            if (property_exists($this, $propertyName)) {
                //Implement special logic for DateTime
                if ($this->{$propertyName} instanceof \DateTime || $this->{$propertyName} === null) {
                    if ($propertyValue instanceof \DateTime) {
                        $this->{$propertyName} = $propertyValue;
                    } elseif ($propertyValue != '') {
                        $this->{$propertyName} = new \DateTime($propertyValue);
                    } else {
                        $this->{$propertyName} = null;
                    }
                } else {
                    $this->{$propertyName} = $propertyValue;
                }
            }
        }

        //Set the messages.
        $this->errors = $errors;
    }

    //Validate the data currently in the model.
    public function validateData(): bool
    {
        //Reset the error messages at the beginning of the validation.
        $this->errors = [];

        //The rulesets are stored as an associative array where the key is the name of the property to be validated.
        //The value are the rules. The rules are again an associative array.
        //For each rule the key stores the name of the rule. 
        //For each rule the value stores the parameters if applicable (i.e., can be an empty array).
        $rulesets = static::getRulesets();

        foreach ($rulesets as $property => $rules) {
            $value = $this->{$property};
            foreach ($rules as $ruleName => $parameters) {
                switch ($ruleName) {
                    case Rule::REQUIRED:
                        if (!$value) {
                            $this->addError($property, $this->getLabel($property), Rule::REQUIRED, $parameters);
                        }
                        break;
                    case Rule::MIN_LENGTH;
                        if (strlen($value) < $parameters[RuleParameter::MIN]) {
                            $this->addError($property, $this->getLabel($property), Rule::MIN_LENGTH, $parameters);
                        }
                        break;
                    case Rule::MAX_LENGTH;
                        if (strlen($value) > $parameters[RuleParameter::MAX]) {
                            $this->addError($property, $this->getLabel($property), Rule::MAX_LENGTH, $parameters);
                        }
                        break;
                    case Rule::UNIQUE:
                        if ($this->isUnique($property) != true) {
                            $this->addError($property, $this->getLabel($property), Rule::UNIQUE, $parameters);
                        }
                        break;
                    case Rule::EXISTS:
                        $exists = call_user_func([$parameters[RuleParameter::CLASSNAME], 'checkExistence'], $value);
                        if ($exists != true) {
                            $this->addError($property, $this->getLabel($property), Rule::EXISTS, $parameters);
                        }
                        break;
                    case Rule::EMAIL:
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($property, $this->getLabel($property), Rule::EMAIL, $parameters);
                        }
                        break;
                    case Rule::NUMBER:
                        //Not yet implemented!
                        break;
                    case Rule::MATCH:
                        if ($value !== $this->{$parameters[RuleParameter::MATCH]}) {
                            $this->addError($property, $this->getLabel($property), Rule::MATCH, $parameters);
                        }
                        break;
                    case Rule::OPTIONS:
                        if (!in_array($value, $parameters[RuleParameter::OPTIONS])) {
                            $this->addError($property, $this->getLabel($property), Rule::OPTIONS, $parameters);
                        }
                        break;
                    case Rule::ISBN:
                        if (!preg_match('/^\d{3}-\d{10}$/', $value)) {
                            $this->addError($property, $this->getLabel($property), Rule::ISBN, $parameters);
                        }
                        break;
                }
            }
        }

        //Check if errors exist.
        return !$this->hasError();
    }

    //Get the data to sore in session context. 
    public function toHttp(): array
    {

        $propertyNames = self::getPropertyNames();
        $properties = [];

        foreach ($propertyNames as $propertyName) {
            $properties[$propertyName] = $this->{$propertyName};
        }

        return [
            'properties' => $properties,
            'errors' => $this->errors
        ];
    }

    //Add an error to the model.
    private function addError(string $propertyName, string $propertyLabel, string $ruleName, array $parameters)
    {
        $this->errors[$propertyName][] = Rule::constructErrorMessage($propertyName, $propertyLabel, $ruleName, $parameters);
    }

    //Check if an error exists (for a given property).
    public function hasError(string $property = ''): bool
    {
        if ($property != '') {
            if (key_exists($property, $this->errors)) {
                return true;
            } else {
                return false;
            }
        } else {
            return !empty($this->errors);
        }
    }

    //Get the first error (for a given property).
    public function getFirstError(string $property): string
    {
        return  $this->errors[$property][0] ?? '';
    }
}
