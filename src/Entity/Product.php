<?php

namespace Entity;

class Product
{
    private const MIN_NAME_LENGTH = 1;
    private const MAX_NAME_LENGTH = 50;
    private const MIN_PRICE_CENTS = 1;
    private const MAX_PRICE_CENTS = 100000;
    private const MAX_DESCRIPTION_LENGTH = 255;
    private const MAX_SIGN_LENGTH = 10;

    private const ERROR_INVALID_PRODUCT_ID = 'Product ID must be positive.';
    private const ERROR_INVALID_NAME_LENGTH = 'Product name must be between 1 and 50 characters.';
    private const ERROR_INVALID_PRICE = 'Price must be between 1 and 100000 cents.';
    private const ERROR_INVALID_DESCRIPTION_LENGTH = 'Description must not exceed 255 characters.';
    private const ERROR_INVALID_SIGN_LENGTH = 'Signature must not exceed 10 characters.';

    private int $productId;
    private string $name;
    private int $priceCents;
    private string $description;
    private string $sign;

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        if ($productId <= 0) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_PRODUCT_ID);
        }
        $this->productId = $productId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (strlen($name) < self::MIN_NAME_LENGTH || strlen($name) > self::MAX_NAME_LENGTH) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_NAME_LENGTH);
        }
        $this->name = $name;
    }

    public function getPriceCents(): int
    {
        return $this->priceCents;
    }

    public function setPriceCents(int $priceCents): void
    {
        if ($priceCents < self::MIN_PRICE_CENTS || $priceCents > self::MAX_PRICE_CENTS) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_PRICE);
        }
        $this->priceCents = $priceCents;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        if (strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_DESCRIPTION_LENGTH);
        }
        $this->description = $description;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function setSign(string $sign): void
    {
        if (strlen($sign) > self::MAX_SIGN_LENGTH) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_SIGN_LENGTH);
        }
        $this->sign = $sign;
    }
}
