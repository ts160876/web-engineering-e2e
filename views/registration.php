<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;

$this->title = 'Registration';
$form = new Form('', 'post', $model);
?>

<h1><?= htmlspecialchars($this->title) ?></h1>
<?= $form->start(); ?>
<?= $form->field(Field::TEXT, 'firstName'); ?>
<?= $form->field(Field::TEXT, 'lastName'); ?>
<?= $form->field(Field::EMAIL, 'email'); ?>
<?= $form->field(Field::PASSWORD, 'password'); ?>
<?= $form->field(Field::PASSWORD, 'confirmPassword'); ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Register') ?>
<?= $form->end(); ?>