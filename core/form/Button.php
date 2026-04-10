<?php

namespace Bukubuku\Core\Form;

class Button
{
    public const SUBMIT = 'submit';

    public string $type;
    public string $buttonName;
    public string $buttonText;
    public Form $form;

    public function __construct(string $type, string $buttonName, string $buttonText, Form $form)
    {
        $this->type = $type;
        $this->buttonName = $buttonName;
        $this->buttonText = $buttonText;
        $this->form = $form;
    }

    //Print the field
    public function __toString()
    {
        return sprintf(
            '<button type="%s" id="%s" name="%s" class="btn btn-primary">%s</button>',
            $this->type,
            $this->buttonName,
            $this->buttonName,
            $this->buttonText
        );
    }
}
