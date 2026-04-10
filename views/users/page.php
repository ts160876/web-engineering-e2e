<?php
$this->title = 'List Users (Paged)';
$nextPage = (int) $page + 1;
$previousPage = (int) $page - 1;
?>

<h1>List Users (Paged)</h1>

<a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/users/create" role="button">Create User</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">E-Mail</th>
            <th scope="col">Password</th>
            <th scope="col">Is Administrator</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><a href="/web-engineering-e2e/public/index.php/users/display?userId=<?= $user['userId'] ?>"><?= $user['userId'] ?></a></td>
                <td><?= $user['firstName'] ?></td>
                <td><?= $user['lastName'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['password'] ?></td>
                <td><?= $user['isAdmin'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/users/page?page=<?= $previousPage ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/web-engineering-e2e/public/index.php/users/page?page=<?= $nextPage ?>">Next</a></li>
    </ul>
</nav>