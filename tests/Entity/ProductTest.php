<?php

use PHPUnit\Framework\TestCase;
use Entity\Product;

class ProductTest extends TestCase
{
    private const PRODUCT_ID = 1;
    private const PRODUCT_NAME = 'Produkt Testowy';
    private const PRODUCT_DESCRIPTION = 'Testowy opis produktu';
    private const PRODUCT_PRICE_CENTS = 2024;
    private const PRODUCT_SIGN = 'AABB111';

    public function testProductCreation()
    {
        $product = new Product();

        $product->setProductId(self::PRODUCT_ID);
        $product->setName(self::PRODUCT_NAME);
        $product->setDescription(self::PRODUCT_DESCRIPTION);
        $product->setPriceCents(self::PRODUCT_PRICE_CENTS);
        $product->setSign(self::PRODUCT_SIGN);

        $this->assertEquals(self::PRODUCT_ID, $product->getProductId());
        $this->assertEquals(self::PRODUCT_NAME, $product->getName());
        $this->assertEquals(self::PRODUCT_PRICE_CENTS, $product->getPriceCents());
        $this->assertEquals(self::PRODUCT_DESCRIPTION, $product->getDescription());
        $this->assertEquals(self::PRODUCT_SIGN, $product->getSign());
    }
}