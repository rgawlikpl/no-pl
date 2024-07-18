<?php

namespace Core\Interfaces;

interface ValidatorInterface
{
    public function validate($entity): void;
}
