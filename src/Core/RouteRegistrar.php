<?php

namespace Core;

use Core\Attributes\Route;
use ReflectionClass;
use ReflectionMethod;

class RouteRegistrar
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function register(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflection = new ReflectionClass($controller);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->router->register($route->method, $route->path, [$controller, $method->getName()]);
                }
            }
        }
    }
}
