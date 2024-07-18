<?php

require 'vendor/autoload.php';

use Core\Request;
use Core\Router;
use Core\RouteRegistrar;

use Entity\Product;
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

// Test data (celowo pomijam service dla zmniejszenia ilości kodu przykładowego)
$p1 = new Product();
$p1->setProductId($productRepository->getNextAvailableProductId());
$p1->setName('Produkt Testowy');
$p1->setDescription('Testowy opis produktu');
$p1->setPriceCents(2024);
$p1->setSign('AABB111');

$productService->createProduct($p1);

// Request dispatcher
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$router->dispatch($requestMethod, $requestUri);

//$p1->setPriceCents(5555);
//$productService->updateProduct($p1);

//echo "\nProduct list:\n";
//print_r($productService->getAllProducts());
