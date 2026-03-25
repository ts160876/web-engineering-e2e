<?php

namespace Bukubuku\Core\Form;

use Bukubuku\Core\Model;

class Form
{
    public string $action;
    public string $method;
    public Model $model;
    public array $fields;
    public array $buttons;

    public function __construct(string $action, string $method, Model $model)
    {
        $this->action = $action;
        $this->method = $method;
        $this->model = $model;
        $this->fields = [];
        $this->buttons = [];
    }

    //Add a field to the form.
    public function field(string $type, string $propertyName): Field
    {
        $field = new Field($type, $propertyName, $this);
        $this->fields[] = $field;
        return $field;
    }

    //Add a button to the form.
    public function button(string $type, string $buttonName, string $buttonText)
    {
        $button = new Button($type, $buttonName, $buttonText, $this);
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
