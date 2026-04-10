<?php

use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;

$this->title = 'Edit Checkout';

$form = new Form('', 'post', $model);

?>

<h1>Edit Book</h1>
<?= $form->start(); ?>
<?= $form->field(Field::NUMBER, 'checkoutId', true); ?>
<?= $form->field(Field::NUMBER, 'userId'); ?>
<?= $form->field(Field::NUMBER, 'bookId'); ?>
<?= $form->field(Field::DATETIME, 'startTime'); ?>
<?= $form->field(Field::DATETIME, 'endTime') ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Save') ?>
<?= $form->end(); ?>