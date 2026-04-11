<?php

use Bukubuku\Core\Application;
use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;

if (Application::$app->isAdmin() == true) {
    $readonly = false;
    $this->title = 'Edit Checkout';
} else {
    $readonly = true;
    $this->title = 'Display Checkout';
}

$form = new Form('', 'post', $model, $readonly);

?>

<h1><?= $this->title ?></h1>
<?= $form->start(); ?>
<?= $form->field(Field::NUMBER, 'checkoutId', true); ?>
<?= $form->field(Field::NUMBER, 'userId'); ?>
<?= $form->field(Field::NUMBER, 'bookId'); ?>
<?= $form->field(Field::DATETIME, 'startTime'); ?>
<?= $form->field(Field::DATETIME, 'endTime') ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Save', $readonly) ?>
<?= $form->end(); ?>