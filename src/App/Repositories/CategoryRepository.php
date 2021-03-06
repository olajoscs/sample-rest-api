<?php

namespace App\Repositories;

use App\Models\Category;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
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
    protected $cache = [];


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
        return array_values($this->cache);
    }


    /**
     * Find and return the category with the ID
     *
     * @param int $id
     *
     * @return Category
     * @throws MappingException
     */
    public function findById(int $id): Category
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        throw new MappingException('No Category: '. $id);
    }


    /**
     * Find and return the category by url
     *
     * @param string $url
     *
     * @return Category
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function findByUrl(string $url): Category
    {
        return $this->connection
            ->select()
            ->from($this->dummy->getTableName())
            ->where('url', '=', $url)
            ->getOneClass($this->getModelClass());
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
