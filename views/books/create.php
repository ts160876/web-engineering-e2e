<?php

use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;
use Bukubuku\Models\Book;

$this->title = 'Create Book';

$form = new Form('', 'post', $model);

?>

<h1>Create Book</h1>
<?= $form->start(); ?>
<?= $form->field(Field::TEXT, 'title'); ?>
<?= $form->field(Field::TEXT, 'author'); ?>
<?= $form->field(Field::TEXT, 'isbn'); ?>
<?= $form->field(Field::DATE, 'published') ?>
<?= $form->field(Field::NUMBER, 'pages') ?>
<?= $form->dropdownField('format', Book::getFormatDropdown()) ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Save') ?>
<?= $form->end(); ?>