<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 10:02
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\ClientApi\Rest\RestClientApi;
use Nokaut\ApiKit\Converter\ProductConverter;
use Nokaut\ApiKit\Converter\ProductsConverter;

class ProductsRepository
{
    /**
     * @var ProductsConverter
     */
    private $converterProducts;
    /**
     * @var ProductConverter
     */
    private $converterProduct;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var RestClientApi
     */
    private $productApiClient;

    public static $fieldsForProductBox = [
        'id', 'url', 'product_id', 'title', 'prices', 'offer_count', 'shop_count', 'category_id', 'offer_id',
        'url_original', 'offer_shop_id', 'shop_name', 'shop_url', 'top_category_id', 'top_position', 'photo_id'
    ];

    public static $fieldsForProductPage = [
        'id','url','category_id','description_html','description_html_generated','id','price_min','price_max',
        'is_with_photo','photo_id','producer_name','product_type_id','source','source_id','title','title_normalized',
        'properties','photo_ids','block_adsense','movie'
    ];

    public static $fieldsForList = [
        'id','product_id','title','prices','offer_count','url','shop','shop.url_logo','shop_count','category_id',
        'offer_id','click_url','click_value','url_original','producer_name','offer_shop_id','shop.name','shop_url',
        'shop_id','top_category_id','top_position','photo_id','description_html','properties','_metadata.url',
        '_metadata.facets.shops.url','_metadata.block_adsense','offer','block_adsense','_metadata.facets.categories.url'
    ];

    public static $fieldsForSimilarProductsInProductPage = ['id','url','title','prices','photo_id'];

    function __construct(Config $config)
    {
        $this->converterProducts = new ProductsConverter();
        $this->converterProduct = new ProductConverter();
        $this->config = $config;

        $oauth2 = new Oauth2Plugin();
        $oauth2->setAccessToken($this->config->getApiAccessToken());
        $this->productApiClient = new RestClientApi($this->config->getCache(), $this->config->getLogger(), $oauth2);
    }

    /**
     * @param int $limit
     * @return Products
     */
    public function fetchProducts($limit)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setLimit($limit);
        $query->setFields(self::$fieldsForProductBox);

        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @return Products
     */
    public function fetchProductsByProducerName($producerName, $limit)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setProducerName($producerName);
        $query->setLimit($limit);
        $query->setFields(self::$fieldsForProductBox);

        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param array $categoryIds
     * @param int $limit
     * @return Products
     */
    public function fetchProductsByCategory(array $categoryIds, $limit)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setCategoryIds($categoryIds);
        $query->setLimit($limit);
        $query->setFields(self::$fieldsForProductBox);

        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param Product $product
     * @param int $limit
     * @return Products
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setCategoryIds([$product->getCategoryId()]);
        $query->setFilterPriceMinFrom($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields(self::$fieldsForProductBox);
        $query->setOrder('price_min', 'desc');

        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param Product $product
     * @param int $limit
     * @return Products
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setCategoryIds([$product->getCategoryId()]);
        $query->setFilterPriceMinTo($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields(self::$fieldsForProductBox);
        $query->setOrder('price_min', 'asc');

        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    public function fetchProductsByQuery(ProductsQuery $query)
    {
        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Product
     */
    public function fetchProductById($id, array $fields)
    {
        $query = new ProductQuery($this->config->getApiUrl());
        $query->setFields($fields);
        $query->setProductId($id);
        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProduct($objectsFromApi);
    }

    /**
     * @param string $url
     * @param array $fields
     * @return Product
     */
    public function fetchProductByUrl($url, array $fields)
    {
        $query = new ProductQuery($this->config->getApiUrl());
        $query->setFields($fields);
        $query->setUrl($url);
        $objectsFromApi = $this->productApiClient->send($query);

        return $this->convertProduct($objectsFromApi);
    }

    public function fetchCountProductsByPhrase($phrase)
    {
        $query = new ProductsQuery($this->config->getApiUrl());
        $query->setFields(['id']);
        $query->setPhrase($phrase);

        $objectsFromApi = $this->productApiClient->send($query);

        if (isset($objectsFromApi->_metadata->total)) {
            return $objectsFromApi->_metadata->total;
        } else {
            return 0;
        }
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Products
     */
    private function convertProducts(\stdClass $objectFromApi)
    {
        return $this->converterProducts->convert($objectFromApi);
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Product
     */
    private function convertProduct(\stdClass $objectFromApi)
    {
        return $this->converterProduct->convert($objectFromApi);
    }
}