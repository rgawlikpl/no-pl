<?php

namespace Controller;

use Core\Request;
use Core\Attributes\Route;
use Core\Response;
use Entity\Product;
use Service\Product\ProductService;

class ProductController
{
    private Request $request;
    private ProductService $productService;

    public function __construct(Request $request, ProductService $productService)
    {
        $this->request = $request;
        $this->productService = $productService;
    }

    #[Route('GET', '/products')]
    public function listProducts(): Response
    {
        $products = $this->productService->getAllProducts();
        $formattedProducts = [];

        foreach ($products as $product) {
            $formattedProducts[] = $this->productService->formatProduct($product);
        }

        return new Response(Response::STATUS_OK, null, $formattedProducts);
    }

    #[Route('GET', '/product/{id}')]
    public function showProduct(int $id): Response
    {
        $product = $this->productService->getProduct($id);

        if ($product === null) {
            return new Response(Response::STATUS_NOT_FOUND, 'Product not found.');
        }

        return new Response(Response::STATUS_OK, null, $this->productService->formatProduct($product));
    }

    #[Route('POST', '/product')]
    public function createProduct(): Response
    {
        $product = new Product();
        $product->setName($this->request->getPostData('name'),);
        $product->setPriceCents($this->request->getPostData('priceCents'));
        $product->setDescription($this->request->getPostData('description'));
        $product->setSign($this->request->getPostData('sign'));

        try {
            $product = $this->productService->createProduct($product);

            return new Response(
                Response::STATUS_CREATED,
                'Product created successfully with ID: ' . $product->getProductId()
            );
        } catch (\InvalidArgumentException $e) {
            return new Response(Response::STATUS_BAD_REQUEST, $e->getMessage());
        }
    }

    #[Route('PUT', '/product/{id}')]
    public function updateProduct(int $id): Response
    {
        $product = $this->productService->getProduct($id);

        if ($product === null) {
            return new Response(Response::STATUS_NOT_FOUND, 'Product not found.');
        }

        $product->setName($this->request->getPutData('name'));
        $product->setPriceCents($this->request->getPutData('priceCents'));
        $product->setDescription($this->request->getPutData('description'));
        $product->setSign($this->request->getPutData('sign'));

        $product = $this->productService->updateProduct($product);

        if ($product === null) {
            return new Response(Response::STATUS_NOT_FOUND, 'Product not found.');
        }

        return new Response(Response::STATUS_OK, 'Product updated successfully with ID: ' . $product->getProductId());
    }

    #[Route('DELETE', '/product/{id}')]
    public function deleteProduct(int $id): Response
    {
        if ($this->productService->deleteProduct($id)) {
            return new Response(Response::STATUS_OK, 'Product deleted successfully.');
        } else {
            return new Response(Response::STATUS_NOT_FOUND, 'Product not found.');
        }
    }
}
