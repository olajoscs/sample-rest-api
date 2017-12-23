<?php

namespace App\Services\Response;

use App\Models\Product as ProductEntity;
use App\Models\Response\Category;
use App\Models\Response\Product;
use App\Repositories\CategoryRepositoryInterface;

/**
 * Class ProductBuilder
 *
 * Build a product from the entity object to the output
 */
class ProductBuilder
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
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryBuilder
     */
    private $categoryBuilder;


    /**
     * Create a new ProductBuilder object
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CategoryBuilder             $categoryBuilder
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryBuilder $categoryBuilder)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryBuilder    = $categoryBuilder;
    }


    /**
     * Build the product from the product entity
     *
     * @param ProductEntity $product
     *
     * @return Product
     */
    public function buildFromProduct(ProductEntity $product): Product
    {
        return $this
            ->setId($product->getId())
            ->setName($product->getName())
            ->setCategoryId($product->getCategoryId())
            ->setPrice($product->getPrice())
            ->setDescription($product->getDescription())
            ->setUrl($product->getUrl())
            ->build();
    }


    /**
     * Set the ID of the product
     *
     * @param int $id
     *
     * @return ProductBuilder
     */
    public function setId(int $id): ProductBuilder
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Set the name of the product
     *
     * @param string $name
     *
     * @return ProductBuilder
     */
    public function setName(string $name): ProductBuilder
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Set the price of the product
     *
     * @param int $price
     *
     * @return ProductBuilder
     */
    public function setPrice(int $price): ProductBuilder
    {
        $this->price = $price;

        return $this;
    }


    /**
     * Set the description of the product
     *
     * @param string $description
     *
     * @return ProductBuilder
     */
    public function setDescription(string $description): ProductBuilder
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Set the url of the product
     *
     * @param string $url
     *
     * @return ProductBuilder
     */
    public function setUrl(string $url): ProductBuilder
    {
        $this->url = $url;

        return $this;
    }


    /**
     * Get the ID of the product
     *
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }


    /**
     * Get the category of the product
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        $category = $this->categoryRepository->findById($this->getCategoryId());

        return $this->categoryBuilder->setId($category->getId())
            ->setName($category->getName())
            ->setUrl($category->getUrl())
            ->build();
    }


    /**
     * Set the category ID of the product
     *
     * @param int $categoryId
     *
     * @return ProductBuilder
     */
    public function setCategoryId(int $categoryId): ProductBuilder
    {
        $this->categoryId = $categoryId;

        return $this;
    }


    /**
     * Build the product from the set properties
     *
     * @return Product
     */
    public function build(): Product
    {
        return new Product($this);
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
}
