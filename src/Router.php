<?php

class Router
{
    private array $routes = [];

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(string $url, string $controller, string $action): void
    {
        $this->routes[$url] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch(string $url): void
    {
        if (isset($this->routes[$url])) {
            $route = $this->routes[$url];
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controller = new $controllerName($this->pdo);

            if (!method_exists($controller, $action)) {
                http_response_code(500);
                echo "Error: method $action not found in controller $controllerName";
                return;
            }

            $controller->$action();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
