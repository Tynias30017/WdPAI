<?php

declare(strict_types=1);

namespace Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, array $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                $class = $route['action'][0];
                $action = $route['action'][1];

                $controller = new $class();
                $controller->$action();

                return;
            }
        }

        throw new \Exception("Route not found: $uri", 404);
    }
}
