<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 12:30
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductsAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKit\Converter\ProductsWithBestOfferConverter;
use Nokaut\ApiKit\Entity\Product;

class ProductsAsyncRepository extends ProductsRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->apiBaseUrl = $apiBaseUrl;
        $this->asyncRepo = AsyncRepository::getInstance($clientApi);
    }

    public function clearAllFetches()
    {
        $this->asyncRepo->clearAllFetches();
    }

    public function fetchAllAsync()
    {
        $this->asyncRepo->fetchAllAsync();
    }

    /**
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchProducts($limit, array $fields)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchProducts($limit, $fields));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByProducerName($producerName, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchProductsByProducerName($producerName, $limit, $fields));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param array $categoryIds
     * @param int $limit
     * @param array $fields
     * @param Sort $sort
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByCategory(array $categoryIds, $limit, array $fields, Sort $sort = null)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchProductsByCategory($categoryIds, $limit, $fields, $sort));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchSimilarProductsWithHigherPrice($product, $limit, $fields));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchSimilarProductsWithLowerPrice($product, $limit, $fields));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param ProductsQuery $query
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByQuery(ProductsQuery $query)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($query);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param ProductsQuery $query
     * @return AsyncFetch
     */
    public function fetchProductsWithBestOfferByQuery(ProductsQuery $query)
    {
        $asyncFetch = new AsyncFetch($query, new ProductsWithBestOfferConverter());
        $this->asyncRepo->addFetch($asyncFetch);
        return $asyncFetch;
    }

    /**
     * @param string $id
     * @param array $fields
     * @return ProductAsyncFetch
     */
    public function fetchProductById($id, array $fields)
    {
        $productAsyncFetch = new ProductAsyncFetch($this->prepareQueryForFetchProductById($id, $fields));
        $this->asyncRepo->addFetch($productAsyncFetch);
        return $productAsyncFetch;
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByUrl($url, array $fields, $limit = 20)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchProductsByUrl($url, $fields, $limit));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param string $url
     * @param array $fields
     * @return ProductAsyncFetch
     */
    public function fetchProductByUrl($url, array $fields)
    {
        $productAsyncFetch = new ProductAsyncFetch($this->prepareQueryForFetchProductByUrl($url, $fields));
        $this->asyncRepo->addFetch($productAsyncFetch);
        return $productAsyncFetch;
    }

    /**
     * @param string $url
     * @param array $fields
     * @return AsyncFetch
     */
    public function fetchProductWithBestOfferByUrl($url, array $fields)
    {
        $asyncFetch = new AsyncFetch($this->prepareQueryForFetchProductByUrl($url, $fields), new ProductsWithBestOfferConverter());
        $this->asyncRepo->addFetch($asyncFetch);
        return $asyncFetch;
    }

    /**
     * @param string $phrase
     * @return ProductsAsyncFetch
     */
    public function fetchCountProductsByPhrase($phrase)
    {
        $productsAsyncFetch = new ProductsAsyncFetch($this->prepareQueryForFetchCountProductsByPhrase($phrase));
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

}