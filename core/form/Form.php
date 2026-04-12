<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\Form;

use Bukubuku\Core\Model;

/**
 * The class Form represents an HTML form.
 */
class Form
{
    /*Action of the form (the form is displayed via GET, the action typically
    submits the form to the same endpoint via POST)*/
    public string $action;
    //Method of the form (GET or POST)
    public string $method;
    //Model to access the content of the form fields as well as errors
    public Model $model;
    //Property to mark a form as readonly
    public bool $readonly;
    /*The following properties store fields, dropdown fields, textareas and buttons
    of the form in four distrinct arrays.
    A better way would be working with a super class FormElement and only have 
    one array.*/
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

    //Print the start tag of the form.
    public function start(): string
    {
        return sprintf('<form action="%s" method="%s">', htmlspecialchars($this->action), htmlspecialchars($this->method)) . PHP_EOL;
    }

    //Print the end tag of the form.
    public function end(): string
    {
        return '</form>' . PHP_EOL;
    }

    //Add a button to the form.
    public function button(string $type, string $buttonName, string $buttonText, bool $readonly = false): Button
    {
        $button = new Button($type, $buttonName, $buttonText, $this, $readonly);
        $this->buttons[] = $button;
        return $button;
    }

    //Add a dropdown field to the form.
    public function dropdownField(string $propertyName, array $options, bool $readonly = false): DropdownField
    {
        $dropdownField = new DropdownField($propertyName, $options, $this, $readonly);
        $this->dropdownFields[] = $dropdownField;
        return $dropdownField;
    }

    //Add a field to the form.
    public function field(string $type, string $propertyName, bool $readonly = false): Field
    {
        $field = new Field($type, $propertyName, $this, $readonly);
        $this->fields[] = $field;
        return $field;
    }

    //Add a textarea to the form.
    public function textarea(string $propertyName, bool $readonly = false): Textarea
    {
        $textarea = new Textarea($propertyName, $this, $readonly);
        $this->textareas[] = $textarea;
        return $textarea;
    }
}
