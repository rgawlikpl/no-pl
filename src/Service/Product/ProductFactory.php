<?php

namespace Service\Product;

use Core\Interfaces\BasicFactoryInterface;
use Entity\Product;

class ProductFactory implements BasicFactoryInterface
{
    public function details(Product $product): array
    {
        return [
            'productId' => $product->getProductId(),
            'name' => $product->getName(),
            'price' => $product->getPriceCents(),
            'description' => $product->getDescription(),
            'sign' => $product->getSign()
        ];
    }

    public function format(Product $product): array
    {
        return [
            'productId' => $product->getProductId(),
            'name' => strtoupper($product->getName()),
            'price' => number_format($product->getPriceCents() / 100, 2, '.', ' ') . ' PLN',
            'description' => $product->getDescription() . "\nSygnatura: " . $product->getSign()
        ];
    }
}
