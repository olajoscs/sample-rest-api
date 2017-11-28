<?php

namespace App\Models;

use OlajosCs\Repository\Exceptions\ValidationException;
use OlajosCs\Repository\Model;

/**
 * Class Product
 *
 *
 */
class Product extends Model
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
     * @var int
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;


    /**
     * Validate the model
     *
     * @return void
     * @throws ValidationException
     *
     * @void
     */
    public function validate(): void
    {
        if (empty($this->name)) {
            throw new ValidationException('Property: name is empty in product');
        }
        if (empty($this->price)) {
            throw new ValidationException('Property: price is empty in product');
        }
        if (empty($this->categoryId)) {
            throw new ValidationException('Property: categoryId is empty in product');
        }
        if (empty($this->description)) {
            throw new ValidationException('Property: description is empty in product');
        }
        if (empty($this->url)) {
            throw new ValidationException('Property: url is empty in product');
        }
    }


    /**
     * Return the name of the table in the database, which stores the model
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'products';
    }


    /**
     * Return the name of the id field of the model if exists
     *
     * @return string
     */
    public static function getIdField(): string
    {
        return 'id';
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
     * Set the name of the product
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
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
     * Set the price of the product
     *
     * @param int $price
     *
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;

        return $this;
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
     *  Set the description of the product
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Return the category ID of the product
     *
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }


    /**
     * Set the category ID of the product
     *
     * @param int $categoryId
     *
     * @return Product
     */
    public function setCategoryId(int $categoryId): Product
    {
        $this->categoryId = $categoryId;

        return $this;
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
     * Set the url of the product
     *
     * @param string $url
     *
     * @return Product
     */
    public function setUrl(string $url): Product
    {
        $this->url = $url;

        return $this;
    }

}
