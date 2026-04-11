<?php

use Bukubuku\Core\Application;

$this->title = 'List Checkouts';
?>

<h1><?= $this->title ?></h1>

<?php if (Application::$app->isAdmin() == true): ?>
    <a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/checkouts/create" role="button">Create Checkout</a>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Checkout ID</th>
            <th scope="col">User ID</th>
            <th scope="col">Book ID</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($checkouts as $checkout): ?>
            <tr>
                <td><a href="/web-engineering-e2e/public/index.php/checkouts/edit?checkoutId=<?= $checkout['checkoutId'] ?>"><?= $checkout['checkoutId'] ?></a></td>
                <td><?= $checkout['userId'] ?></td>
                <td><?= $checkout['bookId'] ?></td>
                <td><?= $checkout['startTime'] ?></td>
                <td><?= $checkout['endTime'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>