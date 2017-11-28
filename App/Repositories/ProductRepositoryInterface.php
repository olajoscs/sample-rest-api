<?php

namespace App\Repositories;

use App\Models\Product;
use OlajosCs\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProductRepositoryInterface
 *
 * Repository for the products
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Find and return all the products
     *
     * @return Product[]
     */
    public function findAll(): array;


    /**
     * Find and return a product based on its ID
     *
     * @param int $id
     *
     * @return Product
     */
    public function findById(int $id): Product;
}
