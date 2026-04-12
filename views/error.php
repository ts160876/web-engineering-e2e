<?php

/**
 * Lecture Web Engineering
 */

$this->title = 'Error';
?>

<h1><?= $this->title ?></h1>
<p><?= $exception->getCode() . ' - ' . $exception->getMessage() ?>