<?php

use Bukubuku\Core\Application;
use Bukubuku\Models\Book;

$this->title = 'List Books';
?>

<h1>List Books</h1>

<a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/books/create" role="button">Create Book</a>

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
                <td><?= Book::getCheckoutStatusText($book['checkoutStatus']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>