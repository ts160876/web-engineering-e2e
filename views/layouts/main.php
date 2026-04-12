<?php

/**
 * Lecture Web Engineering
 */

use Bukubuku\Core\Application;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BukuBuku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- me-auto (margin-end auto) pushes content to the left -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (Application::$app->isAuthorized('/')): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/') ?>">Home</a>
                        </li>
                    <?php endif; ?>

                    <?php if (Application::$app->isAuthorized('/books/create') || Application::$app->isAuthorized('/books/page')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Books
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (Application::$app->isAuthorized('/books/create')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/books/create') ?>">Create Book</a></li>
                                <?php endif; ?>
                                <!-- We only display the paged table
                                <li><a class="dropdown-item" href="/web-engineering-e2e/public/index.php/books/list">List Books</a></li>-->
                                <?php if (Application::$app->isAuthorized('/books/page')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/books/page?page=1') ?>">List Books</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (Application::$app->isAuthorized('/checkouts/create') || Application::$app->isAuthorized('/checkouts/page') || Application::$app->isAuthorized('/checkouts/mycheckouts')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Checkouts
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (Application::$app->isAuthorized('/checkouts/create')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/checkouts/create') ?>">Create Checkout</a></li>
                                <?php endif; ?>
                                <!-- We only display the paged table
                                <li><a class="dropdown-item" href="/web-engineering-e2e/public/index.php/checkouts/list">List Checkouts</a></li>-->
                                <?php if (Application::$app->isAuthorized('/checkouts/page')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/checkouts/page?page=1') ?>">List Checkouts</a></li>
                                <?php endif; ?>
                                <?php if (Application::$app->isAuthorized('/checkouts/mycheckouts')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/checkouts/mycheckouts?page=1') ?>">My Checkouts</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (Application::$app->isAuthorized('/users/create') || Application::$app->isAuthorized('/users/page')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Users
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (Application::$app->isAuthorized('/users/create')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/users/create') ?>">Create User</a></li>
                                <?php endif; ?>
                                <!-- We only display the paged table
                                <li><a class="dropdown-item" href="/web-engineering-e2e/public/index.php/users/list">List Users</a></li>-->
                                <?php if (Application::$app->isAuthorized('/users/page')): ?>
                                    <li><a class="dropdown-item" href="<?= Application::$app->pathToUrl('/users/page?page=1') ?>">List Users</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (Application::$app->isAuthorized('/contact')): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/contact') ?>">Contact</a>
                        </li>
                    <?php endif; ?>

                </ul>
                <!-- ms-auto (margin-start auto) pushes content to the right -->
                <?php if (Application::$app->isAuthorized('/registration') || Application::$app->isAuthorized('/login') || Application::$app->isAuthorized('/myprofile') || Application::$app->isAuthorized('/logout')): ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (Application::$app->isAuthorized('/registration')): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/registration') ?>">Registration</a>
                            </li>
                        <?php endif ?>
                        <?php if (Application::$app->isAuthorized('/login')): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/login') ?>">Login</a>
                            </li>
                        <?php endif ?>
                        <?php if (Application::$app->isAuthorized('/myprofile')): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/myprofile') ?>">Profile</a>
                            </li>
                        <?php endif ?>
                        <?php if (Application::$app->isAuthorized('/logout')): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= Application::$app->pathToUrl('/logout') ?>"><?= 'Logout (' . Application::$app->getFullName() . ')' ?></a>
                            </li>
                        <?php endif ?>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </nav>

    <!-- Here we display the flash messages. -->
    <div class="container">
        <?php if (Application::$app->session->getFlashMemory('success')): ?>
            <div class="alert alert-success"><?= htmlspecialchars(Application::$app->session->getFlashMemory('success')) ?></div>
        <?php elseif (Application::$app->session->getFlashMemory('error')): ?>
            <div class="alert alert-danger"><?= htmlspecialchars(Application::$app->session->getFlashMemory('error')) ?></div>
        <?php endif; ?>
    </div>

    <!-- This is the placeholder where the content of the view is injected. -->
    <div class="container">
        {{content}}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>