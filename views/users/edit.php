<?php

use Bukubuku\Core\Application;
use Bukubuku\Core\Form\Button;
use Bukubuku\Core\Form\Form;
use Bukubuku\Core\Form\Field;
use Bukubuku\Models\User;

if (Application::$app->isAdmin() == true) {
    $readonly = false;
    $this->title = 'Edit User';
} else {
    $readonly = true;
    $this->title = 'Display User';
}

$form = new Form('', 'post', $model, $readonly);

?>

<h1><?= $this->title ?></h1>
<?= $form->start(); ?>
<?= $form->field(Field::NUMBER, 'userId', true); ?>
<?= $form->field(Field::TEXT, 'firstName'); ?>
<?= $form->field(Field::TEXT, 'lastName'); ?>
<?= $form->field(Field::TEXT, 'email'); ?>
<?= $form->dropdownField('isAdmin', User::getIsAdminDropdown()) ?>
<?= $form->field(Field::PASSWORD, 'password'); ?>
<?= $form->field(Field::PASSWORD, 'confirmPassword'); ?>
<?= $form->button(Button::SUBMIT, 'submit', 'Save', $readonly) ?>
<?= $form->end(); ?>