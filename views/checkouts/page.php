<?php
$this->title = 'List Checkouts (Paged)';
$nextPage = (int) $page + 1;
$previousPage = (int) $page - 1;
?>

<h1>List Checkouts (Paged)</h1>

<a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/checkouts/create" role="button">Create Checkout</a>

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

<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/checkouts/page?page=<?= $previousPage ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/checkouts/page?page=<?= $nextPage ?>">Next</a></li>
    </ul>
</nav>