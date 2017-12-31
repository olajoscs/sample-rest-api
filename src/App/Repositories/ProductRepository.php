<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
use OlajosCs\Repository\Exceptions\MappingException;
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
     * @throws MappingException
     */
    public function findById(int $id): Product
    {
        /** @var Product $product */
        $product = $this->get($id);

        return $product;
    }


    /**
     * Find and return all the products which have the category in the parameter
     *
     * @param Category $category
     *
     * @return Product[]
     */
    public function findByCategory(Category $category): array
    {
        return $this->connection
            ->select()
            ->from($this->dummy->getTableName())
            ->where('categoryId', '=', $category->getId())
            ->orderBy($this->dummy->getIdField())
            ->getAsClasses(Product::class);
    }


    /**
     * Return the product with the url in the parameter
     *
     * @param string $url
     *
     * @return Product
     * @throws MappingException
     */
    public function findByUrl(string $url): Product
    {
        try {
            $product = $this->connection
                ->select()
                ->from($this->dummy->getTableName())
                ->where('url', '=', $url)
                ->getOneClass(Product::class);
        } catch (MultipleRowFoundException $e) {
            throw new MappingException($e->getMessage());
        } catch (RowNotFoundException $e) {
            throw new MappingException($e->getMessage());
        }

        return $product;
    }

}
