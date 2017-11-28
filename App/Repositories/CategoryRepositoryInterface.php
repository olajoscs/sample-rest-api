<?php

namespace App\Repositories;

use App\Models\Category;

/**
 * Interface CategoryRepositoryInterface
 *
 * Repository for the categories
 */
interface CategoryRepositoryInterface
{
    /**
     * Find and return all categories
     *
     * @return array
     */
    public function findAll(): array;


    /**
     * Find and return the category with the ID
     *
     * @param int $id
     *
     * @return Category
     */
    public function findById(int $id): Category;
}
