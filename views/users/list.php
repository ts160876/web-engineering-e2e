<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Application;
use Bukubuku\Models\User;

$this->title = 'List Users';
?>

<h1><?= htmlspecialchars($this->title) ?></h1>

<?php if (Application::$app->isAdmin() == true): ?>
    <a class="btn btn-primary" href="/web-engineering-e2e/public/index.php/users/create" role="button">Create User</a>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">E-Mail</th>
            <th scope="col">User Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><a href="/web-engineering-e2e/public/index.php/users/edit?userId=<?= htmlspecialchars($user['userId']) ?>"><?= htmlspecialchars($user['userId']) ?></a></td>
                <td><?= htmlspecialchars($user['firstName']) ?></td>
                <td><?= htmlspecialchars($user['lastName']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars(User::getIsAdminText($user['isAdmin'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>