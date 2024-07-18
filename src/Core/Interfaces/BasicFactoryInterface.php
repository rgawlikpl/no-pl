<?php

namespace Core\Interfaces;

use Entity\Product;

interface BasicFactoryInterface
{
    public function details(Product $product): array;
    public function format(Product $product): array;
}
