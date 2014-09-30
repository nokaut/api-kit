<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 12:30
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Converter\ProductsWithBestOfferConverter;
use Nokaut\ApiKit\Entity\Product;

class ProductsAsyncRepository extends ProductsRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param Config $config
     * @param ClientApiInterface $clientApi
     */
    public function __construct(Config $config, ClientApiInterface $clientApi)
    {
        parent::__construct($config, $clientApi);
        $this->asyncRepo = new AsyncRepository($clientApi);
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
     * @return ProductsFetch
     */
    public function fetchProducts($limit, array $fields)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchProducts($limit, $fields), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @param array $fields
     * @return ProductsFetch
     */
    public function fetchProductsByProducerName($producerName, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchProductsByProducerName($producerName, $limit, $fields), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param array $categoryIds
     * @param int $limit
     * @param array $fields
     * @param Sort $sort
     * @return ProductsFetch
     */
    public function fetchProductsByCategory(array $categoryIds, $limit, array $fields, Sort $sort = null)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchProductsByCategory($categoryIds, $limit, $fields, $sort), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsFetch
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchSimilarProductsWithHigherPrice($product, $limit, $fields), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return ProductsFetch
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchSimilarProductsWithLowerPrice($product, $limit, $fields), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param ProductsQuery $query
     * @return ProductsFetch
     */
    public function fetchProductsByQuery(ProductsQuery $query)
    {
        $productsAsyncFetch = new ProductsFetch($query, $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param ProductsQuery $query
     * @return Fetch
     */
    public function fetchProductsWithBestOfferByQuery(ProductsQuery $query)
    {
        $asyncFetch = new Fetch($query, new ProductsWithBestOfferConverter(), $this->cache);
        $this->asyncRepo->addFetch($asyncFetch);
        return $asyncFetch;
    }

    /**
     * @param string $id
     * @param array $fields
     * @return ProductFetch
     */
    public function fetchProductById($id, array $fields)
    {
        $productAsyncFetch = new ProductFetch($this->prepareQueryForFetchProductById($id, $fields), $this->cache);
        $this->asyncRepo->addFetch($productAsyncFetch);
        return $productAsyncFetch;
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return ProductsFetch
     */
    public function fetchProductsByUrl($url, array $fields, $limit = 20)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchProductsByUrl($url, $fields, $limit), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

    /**
     * @param string $url
     * @param array $fields
     * @return ProductFetch
     */
    public function fetchProductByUrl($url, array $fields)
    {
        $productAsyncFetch = new ProductFetch($this->prepareQueryForFetchProductByUrl($url, $fields), $this->cache);
        $this->asyncRepo->addFetch($productAsyncFetch);
        return $productAsyncFetch;
    }

    /**
     * @param string $url
     * @param array $fields
     * @param int $limit
     * @return Fetch
     */
    public function fetchProductsWithBestOfferByUrl($url, array $fields, $limit = 20)
    {
        $asyncFetch = new Fetch($this->prepareQueryForFetchProductsByUrl($url, $fields, $limit), new ProductsWithBestOfferConverter(), $this->cache);
        $this->asyncRepo->addFetch($asyncFetch);
        return $asyncFetch;
    }

    /**
     * @param string $phrase
     * @return ProductsFetch
     */
    public function fetchCountProductsByPhrase($phrase)
    {
        $productsAsyncFetch = new ProductsFetch($this->prepareQueryForFetchCountProductsByPhrase($phrase), $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }

}