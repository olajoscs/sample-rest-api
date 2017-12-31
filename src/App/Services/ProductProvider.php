<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Response\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\Response\ProductBuilder;
use OlajosCs\Repository\Exceptions\MappingException;

/**
 * Class ProductProvider
 *
 * Return the products for output from the repository
 */
class ProductProvider implements ProductProviderInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductBuilder
     */
    private $productBuilder;


    /**
     * Create a new ProductProvider object
     *
     * @param ProductRepositoryInterface $productRepository
     * @param ProductBuilder             $productBuilder
     */
    public function __construct(ProductRepositoryInterface $productRepository, ProductBuilder $productBuilder)
    {
        $this->productRepository = $productRepository;
        $this->productBuilder = $productBuilder;
    }


    /**
     * Return all products
     *
     * @return Product[]
     */
    public function findAll(): array
    {
        $products = $this->productRepository->findAll();

        $returnProducts = [];
        foreach ($products as $product) {
            $returnProducts[] = $this->productBuilder->buildFromProduct($product);

        }

        return $returnProducts;
    }


    /**
     * Return the product with the ID in the parameter
     *
     * @param int $id
     *
     * @return Product
     * @throws MappingException
     */
    public function findById(int $id): Product
    {
        $product = $this->productRepository->findById($id);

        return $this->productBuilder->buildFromProduct($product);
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
        $products = $this->productRepository->findByCategory($category);

        $returnProducts = [];
        foreach ($products as $product) {
            $returnProducts[] = $this->productBuilder->buildFromProduct($product);

        }

        return $returnProducts;
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
        $product = $this->productRepository->findByUrl($url);

        return $this->productBuilder->buildFromProduct($product);
    }
}
