<?php

namespace Service\Product;

use Core\Interfaces\BasicFactoryInterface;
use Core\Interfaces\ValidatorInterface;
use Repository\ProductRepository;
use Entity\Product;

class ProductService
{
    private ValidatorInterface $validator;
    private BasicFactoryInterface $factory;
    private ProductRepository $repository;

    public function __construct(
        ValidatorInterface $validator,
        BasicFactoryInterface $factory,
        ProductRepository $repository
    ) {
        $this->validator = $validator;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function getProduct(int $id): ?Product
    {
        return $this->repository->findById($id);
    }

    public function getAllProducts(): array
    {
        return $this->repository->findAll();
    }

    public function createProduct(Product $product): Product
    {
        $this->validator->validate($product);

        return $this->repository->createProduct($product);
    }

    public function updateProduct(Product $product): ?Product
    {
        $this->validator->validate($product);

        return $this->repository->updateProduct($product);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->repository->deleteProduct($id);
    }

    public function formatProduct(Product $product): array
    {
        return $this->factory->format($product);
    }
}
