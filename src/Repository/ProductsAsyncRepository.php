<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 12:30
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductsAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKit\Converter\ProductsWithBestOfferConverter;
use Nokaut\ApiKit\Entity\Product;

class ProductsAsyncRepository extends ProductsRepository
{

    /**
     * @param string $apiBaseUrl
     */
    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchProducts($limit, array $fields)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchProducts($limit, $fields));
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByProducerName($producerName, $limit, array $fields)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchProductsByProducerName($producerName, $limit, $fields));
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
        return new ProductsAsyncFetch($this->prepareQueryForFetchProductsByCategory($categoryIds, $limit, $fields, $sort));
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchSimilarProductsWithHigherPrice($product, $limit, $fields));
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsAsyncFetch
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchSimilarProductsWithLowerPrice($product, $limit, $fields));
    }

    /**
     * @param ProductsQuery $query
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByQuery(ProductsQuery $query)
    {
        return new ProductsAsyncFetch($query);
    }

    /**
     * @param ProductsQuery $query
     * @return AsyncFetch
     */
    public function fetchProductsWithBestOfferByQuery(ProductsQuery $query)
    {
        return new AsyncFetch($query, new ProductsWithBestOfferConverter());
    }

    /**
     * @param string $id
     * @param array $fields
     * @return ProductAsyncFetch
     */
    public function fetchProductById($id, array $fields)
    {
        return new ProductAsyncFetch($this->prepareQueryForFetchProductById($id, $fields));
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return ProductsAsyncFetch
     */
    public function fetchProductsByUrl($url, array $fields, $limit = 20)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchProductsByUrl($url, $fields, $limit));
    }

    /**
     * @param string $url
     * @param array $fields
     * @return ProductAsyncFetch
     */
    public function fetchProductByUrl($url, array $fields)
    {
        return new ProductAsyncFetch($this->prepareQueryForFetchProductByUrl($url, $fields));
    }

    /**
     * @param string $phrase
     * @return ProductsAsyncFetch
     */
    public function fetchCountProductsByPhrase($phrase)
    {
        return new ProductsAsyncFetch($this->prepareQueryForFetchCountProductsByPhrase($phrase));
    }

}