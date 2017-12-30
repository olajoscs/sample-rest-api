<?php

namespace App\Services;

use App\Models\Category;

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


    /**
     * Find and return all the products which have the category in the parameter
     *
     * @param Category $category
     *
     * @return array
     */
    public function findByCategory(Category $category): array;
}
