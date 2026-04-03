<?php

//Import the classes.
use Bukubuku\Core\Application;
use Bukubuku\Controllers\SiteController;
use Bukubuku\Controllers\UserController;

//Ensure that errors are propagated to help with troubleshooting.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Ensure that autoloading works.
require_once __DIR__ . '/../vendor/autoload.php';

//Load the content from the .env file.
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//Maintain the authorizations.
$authorizations = [
    'admin' => [
        '/',
        '/profile',
        '/logout',
        '/books/list',
        '/books/display',
        '/books/create',
        '/users/list',
        '/users/display',
        '/users/create',
        '/checkouts/list',
        '/checkouts/display',
        '/checkouts/create'
    ],
    'customer' => [
        '/',
        '/profile',
        '/logout',
        '/books/list',
        '/books/display',
        '/checkouts/list',
        '/checkouts/display',
        '/checkouts/create'
    ],
    'guest' => [
        '/',
        '/contact',
        '/registration',
        '/login'
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

$application->router->registerGet('/registration', [UserController::class, 'registration']);
$application->router->registerPost('/registration', [UserController::class, 'handleRegistration']);
$application->router->registerGet('/login', [SiteController::class, 'login']);
$application->router->registerPost('/login', [SiteController::class, 'handleLogin']);
$application->router->registerGet('/profile', [SiteController::class, 'profile']);
$application->router->registerPost('/profile', [SiteController::class, 'handleProfile']);
$application->router->registerGet('/logout', [SiteController::class, 'handleLogout']);

$application->router->registerGet('/books/list', 'books/list');
$application->router->registerGet('/books/display', 'books/display');
$application->router->registerGet('/books/create', 'books/create');

$application->router->registerGet('/users/list', [UserController::class, 'list']);
$application->router->registerGet('/users/display', 'users/display');
$application->router->registerGet('/users/create', 'users/create');

$application->router->registerGet('/checkouts/list', 'checkouts/list');
$application->router->registerGet('/checkouts/display', 'checkouts/display');
$application->router->registerGet('/checkouts/create', 'checkouts/create');

//Authorizations
$authorizations = [
    'admin' => [
        '/',
        '/profile',
        '/logout',
        '/books/list',
        '/books/display',
        '/books/create',
        '/users/list',
        '/users/display',
        '/users/create',
        '/checkouts/list',
        '/checkouts/display',
        '/checkouts/create'
    ],
    'customer' => [
        '/',
        '/profile',
        '/logout',
        '/books/list',
        '/books/display',
        '/checkouts/list',
        '/checkouts/display',
        '/checkouts/create'
    ],
    'guest' => [
        '/',
        '/contact',
        '/registration',
        '/login'
    ]
];

//Run the application.
$application->run();
