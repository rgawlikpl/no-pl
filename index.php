<?php

require 'vendor/autoload.php';

use Core\Request;
use Core\Router;
use Core\RouteRegistrar;

use Service\Product\ProductFactory;
use Service\Product\ProductService;
use Service\Product\ProductValidator;

use Repository\ProductRepository;
use Controller\ProductController;

// DI (brak kontenera, wstrzykiwanie ręczne dla przykładu)
$request = new Request();
$productValidator = new ProductValidator();
$productFactory = new ProductFactory();
$productRepository = new ProductRepository();
$productService = new ProductService($productValidator, $productFactory, $productRepository);
$productController = new ProductController($request, $productService);

// Router (na podstawie atrybutów zarejestrowanych klas)
$router = new Router();
$routeRegistrar = new RouteRegistrar($router);
$routeRegistrar->register([$productController]);

// Request dispatcher
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$router->dispatch($requestMethod, $requestUri);

