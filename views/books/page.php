<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Application;
use Bukubuku\Models\Book;

$this->title = 'List Books';
$nextPage = (int) $page + 1;
$previousPage = (int) $page - 1;
?>

<h1><?= $this->title ?></h1>

<?php if (Application::$app->isAdmin() == true): ?>
    <a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/books/create" role="button">Create Book</a>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Book ID</th>
            <th scope="col">Cover</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">ISBN</th>
            <th scope="col">Published on</th>
            <th scope="col">Number of Pages</th>
            <th scope="col">Format</th>
            <th scope="col">Checkout Status</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><a href="/web-engineering-e2e/public/index.php/books/edit?bookId=<?= $book['bookId'] ?>"><?= $book['bookId'] ?></a></td>
                <td><img src="<?= Application::$app->getCoverPath($book['isbn']) ?>" alt="<?= $book['isbn'] ?>" height="100"></td>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td><?= $book['isbn'] ?></td>
                <td><?= $book['published'] ?></td>
                <td><?= $book['pages'] ?></td>
                <td><?= Book::getFormatText($book['format']) ?></td>
                <?php if (Application::$app->isCustomer() == true && $book['checkoutStatus'] == 'available'): ?>
                    <td><a href="/web-engineering-e2e/public/index.php/books/checkout?bookId=<?= $book['bookId'] ?>">
                            <?= Book::getCheckoutStatusText($book['checkoutStatus']) ?></a></td>
                <? else: ?>
                    <td><?= Book::getCheckoutStatusText($book['checkoutStatus']) ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/books/page?page=<?= $previousPage ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/books/page?page=<?= $nextPage ?>">Next</a></li>
    </ul>
</nav>