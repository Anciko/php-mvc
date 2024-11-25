<?php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve($method, $path) {
        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        if (is_array($callback)) {
            $controller = new $callback[0];
            $method = $callback[1];

            if (method_exists($controller, $method)) {
                echo call_user_func([$controller, $method]);
                return;
            }
        }

        if (is_callable($callback)) {
            echo call_user_func($callback);
            return;
        }

        http_response_code(500);
        echo "Internal Server Error: Invalid callback.";
    }
}

