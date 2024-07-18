<?php

namespace Repository;

use Entity\Product;

class ProductRepository
{
    private array $products = [];

    public function findById(int $id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getProductId() === $id) {
                return $product;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return $this->products;
    }

    public function getNextAvailableProductId(): int
    {
        return count($this->products) + 1;
    }

    public function createProduct(Product $product): Product
    {
        $product->setProductId($this->getNextAvailableProductId());
        $this->products[] = $product;
        return $product;
    }

    public function updateProduct(Product $product): ?Product
    {
        $existingProduct = $this->findById($product->getProductId());
        if ($existingProduct) {
            $existingProduct->setName($product->getName());
            $existingProduct->setPriceCents($product->getPriceCents());
            $existingProduct->setDescription($product->getDescription());
            $existingProduct->setSign($product->getSign());

            return $existingProduct;
        }
        return null;
    }

    public function deleteProduct(int $id): bool
    {
        foreach ($this->products as $index => $product) {
            if ($product->getProductId() === $id) {
                unset($this->products[$index]);
                return true;
            }
        }
        return false;
    }
}
