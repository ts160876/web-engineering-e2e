<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Application;

$this->title = 'List Checkouts';
$nextPage = (int) $page + 1;
$previousPage = (int) $page - 1;
?>

<h1><?= htmlspecialchars($this->title) ?></h1>

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
                <td><a href="/web-engineering-e2e/public/index.php/checkouts/edit?checkoutId=<?= htmlspecialchars($checkout['checkoutId']) ?>"><?= htmlspecialchars($checkout['checkoutId']) ?></a></td>
                <td><?= htmlspecialchars($checkout['userId']) ?></td>
                <td><?= htmlspecialchars($checkout['bookId']) ?></td>
                <td><?= htmlspecialchars($checkout['startTime']) ?></td>
                <td><?= htmlspecialchars($checkout['endTime']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/checkouts/page?page=<?= htmlspecialchars($previousPage) ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/checkouts/page?page=<?= htmlspecialchars($nextPage) ?>">Next</a></li>
    </ul>
</nav>