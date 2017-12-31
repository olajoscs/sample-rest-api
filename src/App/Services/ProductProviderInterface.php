<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Response\Product;
use OlajosCs\Repository\Exceptions\MappingException;

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
     * Return the product with the ID in the parameter
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
