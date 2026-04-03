<?php
$this->title = 'Error';
?>

<h1>Error</h1>
<p><?= $exception->getCode() . ' - ' . $exception->getMessage() ?>