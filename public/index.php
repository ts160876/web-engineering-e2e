<?php

//Ensure that errors are propagated to help with troubleshooting.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Ensure that autoloading works.
require_once __DIR__ . '/../vendor/autoload.php';

//Import the classes.
use Bukubuku\Core\Application;
use Bukubuku\Controllers\SiteController;
use Bukubuku\Controllers\AuthController;

//Create the application.
$application = new Application(dirname(__DIR__));

//Register some routes.
$application->router->registerGet('/', [SiteController::class, 'home']);
$application->router->registerGet('/contact', [SiteController::class, 'contact']);
$application->router->registerPost('/contact', [SiteController::class, 'handleContact']);

$application->router->registerGet('/registration', [AuthController::class, 'registration']);
$application->router->registerPost('/registration', [AuthController::class, 'handleRegistration']);
$application->router->registerGet('/login', [AuthController::class, 'login']);
$application->router->registerPost('/login', [AuthController::class, 'handleLogin']);

$application->router->registerPost('/register', 'register');

$application->router->registerGet('/books/list', 'books/list');
$application->router->registerGet('/books/display', 'books/display');
$application->router->registerGet('/books/create', 'books/create');

$application->router->registerGet('/users/list', 'users/list');
$application->router->registerGet('/users/display', 'users/display');
$application->router->registerGet('/users/create', 'users/create');

$application->router->registerGet('/checkouts/list', 'checkouts/list');
$application->router->registerGet('/checkouts/display', 'checkouts/display');
$application->router->registerGet('/checkouts/create', 'checkouts/create');

//Run the application.
$application->run();
