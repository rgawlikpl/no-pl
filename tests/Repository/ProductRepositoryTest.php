<?php

use PHPUnit\Framework\TestCase;
use Repository\ProductRepository;
use Entity\Product;

class ProductRepositoryTest extends TestCase
{
    private const PRODUCT_ID = 1;
    private const PRODUCT_NAME = 'Produkt Testowy';
    private const PRODUCT_DESCRIPTION = 'Testowy opis produktu';
    private const PRODUCT_PRICE_CENTS = 2024;
    private const PRODUCT_SIGN = 'AABB111';

    private const PRODUCT_ID_2 = 2;
    private const PRODUCT_NAME_2 = 'Produkt Testowy 2';
    private const PRODUCT_DESCRIPTION_2 = 'Testowy opis produktu 2';
    private const PRODUCT_PRICE_CENTS_2 = 5000;
    private const PRODUCT_SIGN_2 = 'AABB222';

    private ProductRepository $repository;

    private function createTestProduct(): Product
    {
        $product = new Product();

        $product->setProductId(self::PRODUCT_ID);
        $product->setName(self::PRODUCT_NAME);
        $product->setDescription(self::PRODUCT_DESCRIPTION);
        $product->setPriceCents(self::PRODUCT_PRICE_CENTS);
        $product->setSign(self::PRODUCT_SIGN);

        $this->repository->createProduct($product);

        return $product;
    }

    protected function setUp(): void
    {
        $this->repository = new ProductRepository();

        $this->createTestProduct();
    }

    public function testCreateProduct()
    {
        $product = new Product();
        $product->setProductId(self::PRODUCT_ID_2);
        $product->setName(self::PRODUCT_NAME_2);
        $product->setDescription(self::PRODUCT_DESCRIPTION_2);
        $product->setPriceCents(self::PRODUCT_PRICE_CENTS_2);
        $product->setSign(self::PRODUCT_SIGN_2);

        $createdProduct = $this->repository->createProduct($product);
        $this->assertEquals(self::PRODUCT_ID_2, $createdProduct->getProductId());
        $this->assertEquals(self::PRODUCT_NAME_2, $createdProduct->getName());
    }

    public function testFindProductById()
    {
        $product = $this->repository->findById(self::PRODUCT_ID);
        $this->assertNotNull($product);
        $this->assertEquals(self::PRODUCT_NAME, $product->getName());

        $product = $this->repository->findById(self::PRODUCT_ID_2);
        $this->assertNull($product);
    }

}
