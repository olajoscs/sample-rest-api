<?php

namespace App\Repositories;

use App\Models\Category;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
use OlajosCs\Repository\Contracts\RepositoryInterface;
use OlajosCs\Repository\Exceptions\MappingException;

/**
 * Interface CategoryRepositoryInterface
 *
 * Repository for the categories
 */
interface CategoryRepositoryInterface extends RepositoryInterface
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
     * @throws MappingException
     */
    public function findById(int $id): Category;


    /**
     * Find and return the category by url
     *
     * @param string $url
     *
     * @return Category
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function findByUrl(string $url): Category;
}
