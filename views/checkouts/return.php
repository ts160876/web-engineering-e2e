<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;
use Bukubuku\Models\Book;

$this->title = 'Return Book';
$form = new Form('', 'post', $model);
?>

<h1><?= $this->title ?></h1>
<?= $form->start(); ?>
<?= $form->field(Field::NUMBER, 'checkoutId', true); ?>
<?= $form->field(Field::NUMBER, 'userId', true); ?>
<?= $form->field(Field::TEXT, 'firstName', true); ?>
<?= $form->field(Field::TEXT, 'lastName', true); ?>
<?= $form->field(Field::NUMBER, 'bookId', true); ?>
<?= $form->field(Field::TEXT, 'title', true); ?>
<?= $form->field(Field::TEXT, 'author', true); ?>
<?= $form->field(Field::TEXT, 'isbn', true); ?>
<?= $form->field(Field::DATE, 'published', true) ?>
<?= $form->field(Field::NUMBER, 'pages', true) ?>
<?= $form->dropdownField('format', Book::getFormatDropdown(), true) ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Return') ?>
<?= $form->end(); ?>