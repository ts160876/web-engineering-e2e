<?php

namespace Bukubuku\Core\Form;

class Textarea
{
    public string $propertyName;
    public bool $readonly;
    public Form $form;

    public function __construct(string $propertyName, Form $form, bool $readonly = false)
    {
        $this->propertyName = $propertyName;
        $this->form = $form;
        $this->readonly = $readonly;
    }

    //Print the field
    public function __toString()
    {

        //Implement special logic for DateTime
        if ($this->form->model->{$this->propertyName} instanceof \DateTime) {
            //$propertyValue = $this->form->model->{$this->propertyName}->format('Y-m-d');
            $propertyValue = $this->form->model->{$this->propertyName}->format('Y-m-d H:i:s');
        } else {
            $propertyValue = $this->form->model->{$this->propertyName};
        }


        return sprintf(
            '<div class="mb-3">
              <label for="%s">%s</label>
              <textarea id="%s" name="%s" %s class="form-control %s %s">%s</textarea>
              <div class="invalid-feedback">
                %s
              </div>
            </div>',
            $this->propertyName,
            $this->form->model->getLabel($this->propertyName),
            $this->propertyName,
            $this->propertyName,
            $this->readonly ? 'readonly' : '',
            $this->readonly ? 'bg-light' : '',
            $this->form->model->hasError($this->propertyName) ? ' is-invalid' : '',
            $propertyValue,
            $this->form->model->getFirstError($this->propertyName)
        );
    }
}
