<?php

/**
 * Lecture Web Engineering
 */

//Import the classes.
use Bukubuku\Core\Application;
use Bukubuku\Controllers\BookController;
use Bukubuku\Controllers\SiteController;
use Bukubuku\Controllers\UserController;
use Bukubuku\Controllers\CheckoutController;

//Ensure that errors are propagated to help with troubleshooting.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Ensure that autoloading works.
require_once __DIR__ . '/../vendor/autoload.php';

//Load the content from the .env file.
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//Specify authorizations.
$authorizations = [
    //Administrator
    'admin' => [
        '/',
        '/logout',
        '/myprofile',

        '/books/list',
        '/books/page',
        '/books/edit',
        '/books/create',

        '/checkouts/list',
        '/checkouts/page',
        '/checkouts/edit',
        '/checkouts/create',

        '/users/list',
        '/users/page',
        '/users/edit',
        '/users/create',

    ],
    //Customer
    'customer' => [
        '/',
        '/contact',
        '/logout',
        '/myprofile',

        '/books/list',
        '/books/page',
        '/books/edit',
        '/books/checkout',

        '/checkouts/mycheckouts',
        '/checkouts/edit',
        '/checkouts/return'

    ],
    //Guest
    'guest' => [
        '/',
        '/contact',
        '/login',
        '/registration',

        '/books/list',
        '/books/page',
        '/books/edit',
    ]
];

//Create the application.
$application = new Application(
    $_ENV['DB_DSN'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
    dirname(__DIR__),
    $authorizations
);

//Register some routes.
$application->router->registerGet('/', [SiteController::class, 'home']);
$application->router->registerGet('/contact', [SiteController::class, 'contact']);
$application->router->registerPost('/contact', [SiteController::class, 'handleContact']);

$application->router->registerGet('/login', [SiteController::class, 'login']);
$application->router->registerPost('/login', [SiteController::class, 'handleLogin']);
$application->router->registerGet('/logout', [SiteController::class, 'handleLogout']);

$application->router->registerGet('/registration', [UserController::class, 'registration']);
$application->router->registerPost('/registration', [UserController::class, 'handleRegistration']);
$application->router->registerGet('/myprofile', [UserController::class, 'myProfile']);
$application->router->registerPost('/myprofile', [UserController::class, 'handleMyProfile']);

$application->router->registerGet('/books/list', [BookController::class, 'list']);
$application->router->registerGet('/books/page', [BookController::class, 'page']);
$application->router->registerGet('/books/edit', [BookController::class, 'edit']);
$application->router->registerPost('/books/edit', [BookController::class, 'handleEdit']);
$application->router->registerGet('/books/create', [BookController::class, 'create']);
$application->router->registerPost('/books/create', [BookController::class, 'handleCreate']);
$application->router->registerGet('/books/checkout', [BookController::class, 'checkout']);
$application->router->registerPost('/books/checkout', [BookController::class, 'handleCheckout']);

$application->router->registerGet('/checkouts/list', [CheckoutController::class, 'list']);
$application->router->registerGet('/checkouts/page', [CheckoutController::class, 'page']);
$application->router->registerGet('/checkouts/mycheckouts', [CheckoutController::class, 'myCheckouts']);
$application->router->registerGet('/checkouts/edit', [CheckoutController::class, 'edit']);
$application->router->registerPost('/checkouts/edit', [CheckoutController::class, 'handleEdit']);
$application->router->registerGet('/checkouts/create', [CheckoutController::class, 'create']);
$application->router->registerPost('/checkouts/create', [CheckoutController::class, 'handleCreate']);
$application->router->registerGet('/checkouts/return', [CheckoutController::class, 'return']);
$application->router->registerPost('/checkouts/return', [CheckoutController::class, 'handleReturn']);

$application->router->registerGet('/users/list', [UserController::class, 'list']);
$application->router->registerGet('/users/page', [UserController::class, 'page']);
$application->router->registerGet('/users/edit', [UserController::class, 'edit']);
$application->router->registerPost('/users/edit', [UserController::class, 'handleEdit']);
$application->router->registerGet('/users/create', [UserController::class, 'create']);
$application->router->registerPost('/users/create', [UserController::class, 'handleCreate']);

//Run the application.
$application->run();
