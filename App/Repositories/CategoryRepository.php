<?php

namespace App\Repositories;

use App\Models\Category;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\Repository\Exceptions\MappingException;
use OlajosCs\Repository\Repository;

/**
 * Class CategoryRepository
 *
 * Repository for the categories
 */
class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    /**
     * @var Category[]
     */
    protected $cache;


    /**
     * Create a new Repository object
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $categories = $this->getList();

        foreach ($categories as $category) {
            $this->cache[$category->getId()] = $category;
        }
    }


    /**
     * Find and return all categories
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->cache;
    }


    /**
     * Find and return the category with the ID
     *
     * @param int $id
     *
     * @return Category
     * @throws \OlajosCs\Repository\Exceptions\MappingException
     */
    public function findById(int $id): Category
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        throw new MappingException('No Category: '. $id);
    }


    /**
     * Return which model class belongs to the repository
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Category::class;
    }
}
