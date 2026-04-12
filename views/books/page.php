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

<h1><?= htmlspecialchars($this->title) ?></h1>

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
                <td><a href="/web-engineering-e2e/public/index.php/books/edit?bookId=<?= htmlspecialchars($book['bookId']) ?>"><?= htmlspecialchars($book['bookId']) ?></a></td>
                <td><img src="<?= htmlspecialchars(Application::$app->getCoverPath($book['isbn'])) ?>" alt="<?= htmlspecialchars($book['isbn']) ?>" height="100"></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td><?= htmlspecialchars($book['published']) ?></td>
                <td><?= htmlspecialchars($book['pages']) ?></td>
                <td><?= htmlspecialchars(Book::getFormatText($book['format'])) ?></td>
                <?php if (Application::$app->isCustomer() == true && $book['checkoutStatus'] == 'available'): ?>
                    <td><a href="/web-engineering-e2e/public/index.php/books/checkout?bookId=<?= htmlspecialchars($book['bookId']) ?>">
                            <?= htmlspecialchars(Book::getCheckoutStatusText($book['checkoutStatus'])) ?></a></td>
                <? else: ?>
                    <td><?= htmlspecialchars(Book::getCheckoutStatusText($book['checkoutStatus'])) ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/books/page?page=<?= htmlspecialchars($previousPage) ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/books/page?page=<?= htmlspecialchars($nextPage) ?>">Next</a></li>
    </ul>
</nav>