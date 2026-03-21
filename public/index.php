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
$application = new Application;

//Register some routes.
$application->router->registerGet('/', function () {
    return 'Home';
});
$application->router->registerGet('/books', function () {
    return 'Books';
});
$application->router->registerGet('/users', function () {
    return 'Users';
});

//Run the application.
$application->run();
