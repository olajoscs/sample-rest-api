<?php

namespace App\Services\Response;

use App\Models\Response\Category;

/**
 * Class CategoryBuilder
 *
 * Build a category from the entity object to output
 */
class CategoryBuilder
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;


    /**
     * Return the ID of the category
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Set the ID of the category
     *
     * @param int $id
     *
     * @return CategoryBuilder
     */
    public function setId(int $id): CategoryBuilder
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Return the name of the category
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Set the name of the category
     *
     * @param string $name
     *
     * @return CategoryBuilder
     */
    public function setName(string $name): CategoryBuilder
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Return the url of the category
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    /**
     * Set the url of the category
     *
     * @param string $url
     *
     * @return CategoryBuilder
     */
    public function setUrl(string $url): CategoryBuilder
    {
        $this->url = $url;

        return $this;
    }


    /**
     * Build the category with the set properties
     *
     * @return Category
     */
    public function build(): Category
    {
        return new Category($this);
    }
}
