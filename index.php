<?php

require_once 'bootstrap.php';

require_once 'Router.php';
require_once './controller/HomeController.php';
require_once './controller/AdminUserController.php';
require_once './controller/RoleController.php';
require_once './controller/AuthController.php';

/**
 * route url need to start with /
 */
$router = new Router();

// auth route
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// home
$router->get('/', [HomeController::class, 'index']);

// admin users
$router->get('/admin-users', [AdminUserController::class, 'index']);
$router->get('/admin-users/create', [AdminUserController::class, 'create']);
$router->post('/admin-users', [AdminUserController::class, 'store']);
$router->get('/admin-users/{id}/edit', [AdminUserController::class, 'edit']);
$router->post('/admin-users/{id}/update', [AdminUserController::class, 'update']);
$router->post('/admin-users/{id}/delete', [AdminUserController::class, 'destroy']);

// roles
$router->get('/roles', [RoleController::class, 'index']);
$router->get('/roles/create', [RoleController::class, 'create']);
$router->post('/roles', [RoleController::class, 'store']);
$router->get('/roles/{id}/edit', [RoleController::class, 'edit']);
$router->post('/roles/{id}/update', [RoleController::class, 'update']);
$router->post('/roles/{id}/delete', [RoleController::class, 'destroy']);


// Define a POST route
$router->post('/submit', function () {
    return "Form submitted successfully!";
});

// Resolve the route
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->resolve($method, $path);
