<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use OlajosCs\Repository\Contracts\RepositoryInterface;
use OlajosCs\Repository\Exceptions\MappingException;

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
     * @throws MappingException
     */
    public function findById(int $id): Product;


    /**
     * Find and return all the products which have the category in the parameter
     *
     * @param Category $category
     *
     * @return array
     */
    public function findByCategory(Category $category): array;


    /**
     * Return the product with the url in the parameter
     *
     * @param string $url
     *
     * @return Product
     * @throws MappingException
     */
    public function findByUrl(string $url): Product;
}
