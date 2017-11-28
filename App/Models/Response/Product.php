<?php

namespace App\Models\Response;

use App\Models\Category;
use App\Services\Response\ProductBuilder;

/**
 * Class Product
 *
 * Read-only product response object
 */
class Product extends StandardResponseClass
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
     * @var int
     */
    protected $price;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Category
     */
    protected $category;


    /**
     * Create a new Product object
     *
     * @param ProductBuilder $builder
     */
    public function __construct(ProductBuilder $builder)
    {
        $this->id          = $builder->getId();
        $this->name        = $builder->getName();
        $this->price       = $builder->getPrice();
        $this->category    = $builder->getCategory();
        $this->url         = $builder->getUrl();
        $this->description = $builder->getDescription();
    }


    /**
     * Return the ID of the product
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Return the name of the product
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Return the price of the product
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }


    /**
     * Return the description of the product
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Return the url of the product
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    /**
     * Return the category of the product
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
}
