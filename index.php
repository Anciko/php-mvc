<?php
require_once 'Router.php';
require_once './controller/HomeController.php';
require_once './controller/AdminUserController.php';

/**
 * route url need to start with /
 */
$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/admin-users', [AdminUserController::class, 'index']);

// Define a POST route
$router->post('/submit', function () {
    return "Form submitted successfully!";
});

// Resolve the route
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->resolve($method, $path);
