<?php

namespace App\Controllers;

use App\Models\Product;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductProvider;
use App\Validation\ValidationException;
use OlajosCs\Repository\Exceptions\MappingException;
use Particle\Validator\Exception\InvalidValueException;
use Particle\Validator\Validator;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class ProductController
 *
 * Resource controller of the products
 */
class ProductController
{
    use JsonResponseStandard;

    /**
     * @var ProductProvider
     */
    private $productProvider;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;


    /**
     * Create a new ProductController object
     *
     * @param ProductProvider             $productProvider
     * @param ProductRepositoryInterface  $productRepository
     * @param Validator                   $validator
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProductProvider $productProvider,
        ProductRepositoryInterface $productRepository,
        Validator $validator,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productProvider = $productProvider;
        $this->productRepository = $productRepository;
        $this->validator = $validator;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Return all products
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     * @throws \RuntimeException
     */
    public function index(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $products = $this->productProvider->findAll();

        return $this->ok($response, ['results' => $products]);
    }


    /**
     * Return the product with the ID in the url
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     * @throws \RuntimeException
     */
    public function get(ServerRequestInterface $request, Response $response, array $args): Response
    {
        try {
            $product = $this->productProvider->findById((int)$args['id']);
        } catch (MappingException $exception) {
            return $this->error($response, 'Product not found');
        }

        return $this->ok($response, ['result' => $product]);
    }


    /**
     * Update an existing product
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     * @throws \App\Validation\ValidationException
     * @throws \Particle\Validator\Exception\InvalidValueException
     * @throws \RuntimeException
     */
    public function update(ServerRequestInterface $request, Response $response, array $args): Response
    {
        if (!isset($args['id'])) {
            return $this->error($response, 'Update is only allowed with ID');
        }

        $body = $request->getParsedBody();
        $product = $this->productRepository->findById($body['id']);

        if ((int)$body['id'] !== (int)$args['id']) {
            return $this->error($response, 'ID of the object and in the URL must be the same');
        }

        try {
            $product = $this->build($body, $args, $product);
        } catch (ValidationException $exception) {
            return $this->error($response, $exception->getMessage());
        }


        try {
            $this->productRepository->save($product);
            $product = $this->productProvider->findById($product->getId());
        } catch (\PDOException $exception) {
            return $this->error($response, 'Update was not successful');
        }

        return $this->ok($response, ['result' => $product]);
    }


    /**
     * Insert a new product
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param                        $args
     *
     * @return Response
     * @throws \App\Validation\ValidationException
     * @throws \Particle\Validator\Exception\InvalidValueException
     * @throws \RuntimeException
     */
    public function insert(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $body = $request->getParsedBody();
        /** @var Product $product */
        $product = $this->productRepository->create();

        try {
            $product = $this->build($body, $args, $product);
        } catch (ValidationException $exception) {
            return $this->error($response, $exception->getMessage());
        }

        try {
            $this->productRepository->save($product);
        } catch (\PDOException $exception) {
            return $this->error($response, 'Update was not successful');
        }

        return $this->ok($response);
    }


    /**
     * Delete a product
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     * @throws \RuntimeException
     */
    public function delete(ServerRequestInterface $request, Response $response, array $args): Response
    {
        try {
            $product = $this->productRepository->get($args['id']);
        } catch (MappingException $exception) {
            return $this->error($response, 'Product not found: ' . $args['id']);
        }

        $this->productRepository->delete($product);

        return $this->ok($response);
    }


    /**
     * Validate and build a product from the request input
     *
     * @param array   $body
     * @param array   $args
     * @param Product $product
     *
     * @return Product
     * @throws \App\Validation\ValidationException
     * @throws \Particle\Validator\Exception\InvalidValueException
     */
    private function build(array $body, array $args, Product $product): Product
    {
        $this->validate($body);

        return $this->buildProduct($body, $product);
    }


    /**
     * Build a product from the request input
     *
     * @param array   $body
     * @param Product $product
     *
     * @return Product
     */
    private function buildProduct(array $body, Product $product): Product
    {
        $product
            ->setName($body['name'])
            ->setUrl($body['url'])
            ->setDescription($body['description'])
            ->setPrice($body['price'])
            ->setCategoryId($body['categoryId']);

        return $product;
    }


    /**
     * Validate the request body against the Product validator
     *
     * @param array $body
     *
     * @return void
     * @throws ValidationException
     * @throws \Particle\Validator\Exception\InvalidValueException
     */
    private function validate(array $body): void
    {
        $this->validator->required('name')->string()->lengthBetween(1, 150);
        $this->validator->required('url')->regex('/^[\w\d\-\_]+$/')->lengthBetween(1, 150);
        $this->validator->required('description')->string();
        $this->validator->required('price')->integer()->greaterThan(0);
        $this->validator->required('categoryId')->integer()->callback(function ($value) {
            try {
                $this->categoryRepository->findById($value);
            } catch (MappingException $exception) {
                throw new InvalidValueException(
                    'Invalid cateogry ID: ' . $value,
                    'categoryId'
                );
            }

            return true;
        });

        $result = $this->validator->validate($body);

        if ($result->isNotValid()) {
            throw new ValidationException($result->getMessages());
        }
    }
}
