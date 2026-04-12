<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\Form;

/**
 * The class Field represents a field.
 */
class Field
{
    //Currently we only support the following types. Additional ones could be added.
    public const TEXT = 'text';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const DATE = 'date';
    public const DATETIME = 'datetime-local';
    public const NUMBER = 'number';

    //Attributes of the field
    public string $type;
    public string $propertyName;
    public bool $readonly;
    public Form $form;

    public function __construct(string $type, string $propertyName, Form $form, bool $readonly = false)
    {
        $this->type = $type;
        $this->propertyName = $propertyName;
        $this->form = $form;
        if ($form->readonly == true) {
            $this->readonly = true;
        } else {
            $this->readonly = $readonly;
        }
    }

    //Print the field.
    public function __toString()
    {

        //Implement special logic for DateTime.
        if ($this->form->model->{$this->propertyName} instanceof \DateTime) {
            if ($this->type == Field::DATE) {
                //Field represents a date.
                $propertyValue = $this->form->model->{$this->propertyName}->format('Y-m-d');
            } else {
                //Field represents a data and time.
                $propertyValue = $this->form->model->{$this->propertyName}->format('Y-m-d H:i:s');
            }
        } else {
            $propertyValue = $this->form->model->{$this->propertyName};
        }

        return sprintf(
            '<div class="mb-3">
              <label for="%s">%s</label>
              <input type="%s" id="%s" name="%s" value="%s" %s class="form-control %s %s">
              <div class="invalid-feedback">
                %s
              </div>
            </div>',
            $this->propertyName,
            $this->form->model->getLabel($this->propertyName),
            $this->type,
            $this->propertyName,
            $this->propertyName,
            $propertyValue,
            $this->readonly ? 'readonly' : '',
            $this->readonly ? 'bg-light' : '',
            $this->form->model->hasError($this->propertyName) ? ' is-invalid' : '',
            $this->form->model->getFirstError($this->propertyName)
        );
    }
}
