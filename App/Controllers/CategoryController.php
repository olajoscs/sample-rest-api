<?php

namespace App\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Validation\ValidationException;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
use OlajosCs\Repository\Exceptions\MappingException;
use Particle\Validator\Exception\InvalidValueException;
use Particle\Validator\Validator;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class CategoryController
 *
 * Resource controller of the categories
 */
class CategoryController
{
    use JsonResponseStandard;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * Create a new CategoryController object
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Validator                   $validator
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, Validator $validator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
    }


    /**
     * Return the list of the categories
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     *
     * @return Response
     */
    public function index(ServerRequestInterface $request, Response $response): Response
    {
        $categories = $this->categoryRepository->findAll();

        return $this->ok($response, ['results' => $categories]);
    }


    /**
     * Return the details of one category
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param                        $args
     *
     * @return Response
     */
    public function get(ServerRequestInterface $request, Response $response, $args): Response
    {
        $categoryId = $request->getAttribute('id');

        try {
            $category = $this->categoryRepository->findById($categoryId);
        } catch (MappingException $exception) {
            return $this->error($response, $exception->getMessage());
        }

        return $this->ok($response, ['result' => $category]);
    }


    /**
     * Insert a new category
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     *
     * @return Response
     */
    public function insert(ServerRequestInterface $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        /** @var Category $category */
        $category = $this->categoryRepository->create();

        try {
            $category = $this->build($body, $category);
        } catch (ValidationException $exception) {
            return $this->error($response, $exception->getMessage());
        }

        try {
            $this->categoryRepository->save($category);
        } catch (\PDOException $exception) {
            return $this->error($response, 'Insert was not successful');
        }

        return $this->ok($response);
    }


    /**
     * Update an existing category
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     */
    public function update(ServerRequestInterface $request, Response $response, array $args): Response
    {
        if (!isset($args['id'])) {
            return $this->error($response, 'Update is only allowed with ID');
        }

        $body = $request->getParsedBody();

        try {
            $category = $this->categoryRepository->findById($body['id']);
        } catch (MappingException $exception) {
            return $this->error($response, $exception->getMessage());
        }


        if ((int)$body['id'] !== (int)$args['id']) {
            return $this->error($response, 'ID of the object and in the URL must be the same');
        }

        try {
            $category = $this->build($body, $category);
        } catch (ValidationException $exception) {
            return $this->error($response, $exception->getMessage());
        }


        try {
            $this->categoryRepository->save($category);
        } catch (\PDOException $exception) {
            return $this->error($response, 'Update was not successful');
        }

        return $this->ok($response, ['result' => $category]);
    }


    /**
     * Delete an existing category
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     * @param array                  $args
     *
     * @return Response
     */
    public function delete(ServerRequestInterface $request, Response $response, array $args): Response
    {
        try {
            $product = $this->categoryRepository->get($args['id']);
        } catch (MappingException $exception) {
            return $this->error($response, 'Category not found: ' . $args['id']);
        }

        $this->categoryRepository->delete($product);

        return $this->ok($response);
    }


    /**
     * Validate, build and return the category filled data from the input (body)
     *
     * @param array    $body
     * @param Category $category
     *
     * @return Category
     * @throws ValidationException
     */
    private function build(array $body, Category $category): Category
    {
        $this->validate($body);

        return $this->buildCategory($body, $category);
    }


    /**
     * Validate the body for a category
     *
     * @param array $body
     *
     * @return void
     * @throws ValidationException
     */
    private function validate(array $body): void
    {
        $this->validator
            ->required('name')
            ->string()
            ->lengthBetween(1, 150);

        $this->validator
            ->required('url')
            ->regex('/^[\w\d\-\_]+$/')
            ->lengthBetween(1, 150)
            ->callback(function($value) {
                try {
                    $existing = $this->categoryRepository->findByUrl($value);
                } catch (RowNotFoundException $exception) {
                    return true;
                } catch (MultipleRowFoundException $exception) {
                    throw new InvalidValueException($exception->getMessage(), 'url');
                }

                throw new InvalidValueException('Invalid url: ' . $value, 'url');
            });

        $result = $this->validator->validate($body);

        if ($result->isNotValid()) {
            throw new ValidationException($result->getMessages());
        }
    }


    /**
     * Build the category from the input
     *
     * @param array    $body
     * @param Category $category
     *
     * @return Category
     */
    private function buildCategory(array $body, Category $category): Category
    {
        return $category
            ->setName($body['name'])
            ->setUrl($body['url']);
    }
}
