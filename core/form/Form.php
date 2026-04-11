<?php

namespace Bukubuku\Core\Form;

use Bukubuku\Core\Model;

class Form
{
    public string $action;
    public string $method;
    public Model $model;
    public bool $readonly;
    public array $fields;
    public array $dropdownFields;
    public array $textareas;
    public array $buttons;

    public function __construct(string $action, string $method, Model $model, bool $readonly = false)
    {
        $this->action = $action;
        $this->method = $method;
        $this->model = $model;
        $this->readonly = $readonly;
        $this->fields = [];
        $this->dropdownFields = [];
        $this->textareas = [];
        $this->buttons = [];
    }

    //Add a field to the form.
    public function field(string $type, string $propertyName, bool $readonly = false): Field
    {
        $field = new Field($type, $propertyName, $this, $readonly);
        $this->fields[] = $field;
        return $field;
    }

    //Add a dropdown field to the form
    public function dropdownField(string $propertyName, array $options, bool $readonly = false): DropdownField
    {
        $dropdownField = new DropdownField($propertyName, $options, $this, $readonly);
        $this->dropdownFields[] = $dropdownField;
        return $dropdownField;
    }

    //Add a textarea to the form
    public function textarea(string $propertyName, bool $readonly = false)
    {
        $textarea = new Textarea($propertyName, $this, $readonly);
        $this->textareas[] = $textarea;
        return $textarea;
    }

    //Add a button to the form.
    public function button(string $type, string $buttonName, string $buttonText, bool $readonly = false)
    {
        $button = new Button($type, $buttonName, $buttonText, $this, $readonly);
        $this->buttons[] = $button;
        return $button;
    }

    //Print the start tag of the form.
    public function start(): string
    {
        return sprintf('<form action="%s" method="%s">', $this->action, $this->method) . PHP_EOL;
    }

    //Print the end tag of the form.
    public function end(): string
    {
        return '</form>' . PHP_EOL;
    }
}
