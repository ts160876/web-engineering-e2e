<?php

use Bukubuku\Core\Application;
use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;
use Bukubuku\Models\Book;

if (Application::$app->isAdmin() == true) {
    $readonly = false;
    $this->title = 'Edit Book';
} else {
    $readonly = true;
    $this->title = 'Display Book';
}

$form = new Form('', 'post', $model, $readonly);

?>

<h1><?= $this->title ?></h1>
<?= $form->start(); ?>
<?= $form->field(Field::NUMBER, 'bookId', true); ?>
<?= $form->field(Field::TEXT, 'title'); ?>
<?= $form->field(Field::TEXT, 'author'); ?>
<?= $form->field(Field::TEXT, 'isbn'); ?>
<?= $form->field(Field::DATE, 'published') ?>
<?= $form->field(Field::NUMBER, 'pages') ?>
<?= $form->dropdownField('format', Book::getFormatDropdown()) ?>
<?= $form->dropdownField('checkoutStatus', Book::getCheckoutStatusDropdown()) ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Save', $readonly) ?>
<?= $form->end(); ?>