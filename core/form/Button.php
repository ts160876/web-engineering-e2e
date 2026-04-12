<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\Form;

/**
 * The class Button represents a button.
 */
class Button
{
    //Currently we only have tested submit buttons.
    public const SUBMIT = 'submit';

    //Attributes of the button
    public string $type;
    public string $buttonName;
    public string $buttonText;
    public Form $form;
    public bool $readonly;

    public function __construct(string $type, string $buttonName, string $buttonText, Form $form, bool $readonly = false)
    {
        $this->type = $type;
        $this->buttonName = $buttonName;
        $this->buttonText = $buttonText;
        $this->form = $form;
        if ($form->readonly == true) {
            $this->readonly = true;
        } else {
            $this->readonly = $readonly;
        }
    }

    //Print the button.
    public function __toString()
    {
        return sprintf(
            '<button type="%s" id="%s" name="%s" %s class="btn btn-primary">%s</button>',
            htmlspecialchars($this->type),
            htmlspecialchars($this->buttonName),
            htmlspecialchars($this->buttonName),
            htmlspecialchars($this->readonly ? 'disabled' : ''),
            htmlspecialchars($this->buttonText)
        );
    }
}
