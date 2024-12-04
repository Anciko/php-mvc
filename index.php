<?php

require_once 'bootstrap.php';

require_once 'Router.php';
require_once './controller/HomeController.php';
require_once './controller/AdminUserController.php';
require_once './controller/AuthController.php';

/**
 * route url need to start with /
 */
$router = new Router();

// auth route
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/', [HomeController::class, 'index']);

$router->get('/admin-users', [AdminUserController::class, 'index']);
$router->get('/admin-users/create', [AdminUserController::class, 'create']);
$router->post('/admin-users', [AdminUserController::class, 'store']);
$router->get('/admin-users/{id}', function($id) {
    dd($id);
});


// Define a POST route
$router->post('/submit', function () {
    return "Form submitted successfully!";
});

// Resolve the route
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->resolve($method, $path);
