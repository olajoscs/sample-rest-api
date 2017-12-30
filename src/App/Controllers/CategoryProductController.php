<?php

namespace App\Controllers;

use App\Repositories\CategoryRepositoryInterface;
use App\Services\ProductProviderInterface;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class CategoryProductController
 *
 * Product lister for categories
 */
class CategoryProductController
{
    use JsonResponseStandard;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var ProductProviderInterface
     */
    private $productProvider;


    /**
     * Create a new CategoryProductController object
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ProductProviderInterface    $productProvider
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductProviderInterface $productProvider
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productProvider = $productProvider;
    }


    /**
     * Return the the list of the products by the category url
     *
     * @param ServerRequestInterface $request
     * @param Response               $response
     *
     * @return Response
     */
    public function getList(ServerRequestInterface $request, Response $response): Response
    {
        $categoryUrl = $request->getAttribute('category');

        try {
            $category = $this->categoryRepository->findByUrl($categoryUrl);
        } catch (MultipleRowFoundException $e) {
            return $this->error($response, 'Multiple categories found for url: ' . $categoryUrl);
        } catch (RowNotFoundException $e) {
            return $this->error($response, 'Category not found: ' . $categoryUrl, 404);
        }

        $products = $this->productProvider->findByCategory($category);

        return $this->ok($response, $products);
    }

}
