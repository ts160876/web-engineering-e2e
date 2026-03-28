<h1>List Users</h1>

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
                <td><a href="/web-engineering-e2e/public/index.php/users/display?<?= $user['userId'] ?>"><?= $user['userId'] ?></a></td>
                <td><?= $user['firstName'] ?></td>
                <td><?= $user['lastName'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['password'] ?></td>
                <td><?= $user['isAdmin'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<i class="bi bi-check-square"></i>

<a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/users/create" role="button">Create User</a>