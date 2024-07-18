<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function register(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $requestMethod, string $requestUri): void
    {
        foreach ($this->routes as $route) {
            if ($requestMethod === $route['method'] && preg_match(
                    $this->convertPathToRegex($route['path']),
                    $requestUri,
                    $matches
                )) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        new Response(Response::STATUS_NOT_FOUND, 'Endpoint not found.');
    }

    private function convertPathToRegex(string $path): string
    {
        return '#^' . preg_replace('#\{[^\}]+\}#', '([^/]+)', $path) . '$#';
    }
}
