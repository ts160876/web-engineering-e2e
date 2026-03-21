<?php

//Ensure that errors are propagated to help with troubleshooting.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Ensure that autoloading works.
require_once __DIR__ . '/../vendor/autoload.php';

//Import the classes.
use Bukubuku\Core\Application;

//Create the application.
$application = new Application(dirname(__DIR__));

//Register some routes.
$application->router->registerGet('/', 'home');
$application->router->registerGet('/books/list', 'books/list');
$application->router->registerGet('/books/display', 'books/display');
$application->router->registerGet('/books/create', 'books/create');

$application->router->registerGet('/users/list', 'users/list');
$application->router->registerGet('/users/display', 'users/display');
$application->router->registerGet('/users/create', 'users/create');

$application->router->registerGet('/checkouts/list', 'checkouts/list');
$application->router->registerGet('/checkouts/display', 'checkouts/display');
$application->router->registerGet('/checkouts/create', 'checkouts/create');

$application->router->registerGet('/register', 'register');

$application->router->registerGet('/contact', 'contact');

//Run the application.
$application->run();
