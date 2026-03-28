<?php

namespace Bukubuku\Core\Form;

use Bukubuku\Core\Model;

class Field
{
    public const TEXT = 'text';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    public string $type;
    public string $propertyName;
    public Form $form;

    public function __construct(string $type, string $propertyName, Form $form)
    {
        $this->type = $type;
        $this->propertyName = $propertyName;
        $this->form = $form;
    }

    //Print the field
    public function __toString()
    {

        return sprintf(
            '<div class="mb-3">
              <label for="%s">%s</label>
              <input type="%s" id="%s" name="%s" value="%s" class="form-control %s">
              <div class="invalid-feedback">
                %s
              </div>
            </div>',
            $this->propertyName,
            $this->form->model->getLabel($this->propertyName),
            $this->type,
            $this->propertyName,
            $this->propertyName,
            $this->form->model->{$this->propertyName},
            $this->form->model->hasError($this->propertyName) ? ' is-invalid' : '',
            $this->form->model->getFirstError($this->propertyName)
        );
    }
}
