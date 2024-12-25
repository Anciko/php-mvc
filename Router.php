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
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route => $callback) {
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([a-zA-Z0-9_]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);

                if (is_array($callback)) {
                    $controller = new $callback[0];
                    $method = $callback[1];

                    if (method_exists($controller, $method)) {
                        echo call_user_func_array([$controller, $method], $matches);
                        return;
                    }
                }

                if (is_callable($callback)) {
                    echo call_user_func_array($callback, $matches);
                    return;
                }

                http_response_code(500);
                echo "Internal Server Error: Invalid callback.";
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
