<?php

namespace App\Repositories;

use App\Models\Product;
use OlajosCs\Repository\Repository;

/**
 * Class ProductRepository
 *
 * Repository for the products
 */
class ProductRepository extends Repository implements ProductRepositoryInterface
{
    /**
     * Return which model class belongs to the repository
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Product::class;
    }


    /**
     * Find and return all the products
     *
     * @return Product[]
     */
    public function findAll(): array
    {
        return $this->getList();
    }


    /**
     * Find and return a product based on its ID
     *
     * @param int $id
     *
     * @return Product
     * @throws \OlajosCs\Repository\Exceptions\MappingException
     */
    public function findById(int $id): Product
    {
        /** @var Product $product */
        $product = $this->get($id);

        return $product;
    }

}
