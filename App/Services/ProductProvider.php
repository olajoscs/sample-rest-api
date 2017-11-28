<?php

namespace App\Services;

use App\Models\Response\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\Response\ProductBuilder;

/**
 * Class ProductProvider
 *
 * Return the products for output from the repository
 */
class ProductProvider
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
     */
    public function findById(int $id): Product
    {
        $product = $this->productRepository->findById($id);

        return $this->productBuilder->buildFromProduct($product);
    }
}
