<?php

// class Router 
// {
//     protected $routes = [];

//     public function register($routes)
//     {
//         $this->routes = $routes;
//     }

//     public function direct($uri)
//     {
//         if(array_key_exists($uri, $this->routes)) {
//             return $this->routes[$uri];
//         }else {
//             echo "Route Not Found!";
//             die();
//         }
//     }
// }

// $router = new Router();
$router->register([
    ""      => "controller/AdminUserController.php",
    "about" => "controller/AboutController.php"
]);

// require $router->direct(trim($_SERVER['REQUEST_URI'], "/"));