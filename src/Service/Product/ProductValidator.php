<?php

namespace Service\Product;

use Core\Interfaces\ValidatorInterface;
use Entity\Product;

class ProductValidator implements ValidatorInterface
{
    private const MIN_NAME_LENGTH = 3;
    private const MAX_NAME_LENGTH = 20;
    private const MIN_PRICE_CENTS = 100;
    private const MAX_PRICE_CENTS = 100000;
    private const MAX_DESCRIPTION_LENGTH = 100;

    private const ERROR_INVALID_NAME_LENGTH = "Product name must be between 3 and 20 characters.";
    private const ERROR_INVALID_PRICE = "Price must be between 1 and 1000.";
    private const ERROR_INVALID_DESCRIPTION_LENGTH = "Description must not exceed 100 characters.";

    public function validate($entity): void
    {
        if (!$entity instanceof Product) {
            throw new \InvalidArgumentException('Invalid entity type.');
        }

        $name = $entity->getName();
        if (strlen($name) < self::MIN_NAME_LENGTH || strlen($name) > self::MAX_NAME_LENGTH) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_NAME_LENGTH);
        }

        $priceCents = $entity->getPriceCents();
        if ($priceCents < self::MIN_PRICE_CENTS || $priceCents > self::MAX_PRICE_CENTS) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_PRICE);
        }

        $description = $entity->getDescription();
        if (strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
            throw new \InvalidArgumentException(self::ERROR_INVALID_DESCRIPTION_LENGTH);
        }
    }
}
