<?php

namespace App\Services;

/**
 * Interface ProductProviderInterface
 *
 * Return the products for output from the repository
 */
interface ProductProviderInterface
{
    /**
     * Return
     *
     * @return array
     */
    public function findAll(): array;
}
