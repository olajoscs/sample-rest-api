<?php

namespace App\Models\Response;

use App\Services\Response\CategoryBuilder;

/**
 * Class Category
 *
 * Read-only category response object
 */
class Category extends StandardResponseClass
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;


    /**
     * Create a new Category object
     *
     * @param CategoryBuilder $categoryBuilder
     */
    public function __construct(CategoryBuilder $categoryBuilder)
    {
        $this->id   = $categoryBuilder->getId();
        $this->name = $categoryBuilder->getName();
        $this->url  = $categoryBuilder->getUrl();
    }


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
     * Return the name of the category
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
}
