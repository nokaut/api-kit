<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 10:02
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
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
     * @var ClientApiInterface
     */
    private $clientApi;
    /**
     * @var string
     */
    private $apiBaseUrl;

    public static $fieldsForProductBox = array(
        'id', 'url', 'product_id', 'title', 'prices', 'offer_count', 'shop_count', 'category_id', 'offer_id',
        'url_original', 'offer_shop_id', 'shop_name', 'shop_url', 'top_category_id', 'top_position', 'photo_id'
    );

    public static $fieldsForProductPage = array(
        'id','url','category_id','description_html','description_html_generated','id','price_min','price_max',
        'is_with_photo','photo_id','producer_name','product_type_id','source','source_id','title','title_normalized',
        'properties','photo_ids','block_adsense','movie'
    );

    public static $fieldsForList = array(
        'id','product_id','title','prices','offer_count','url','shop','shop.url_logo','shop_count','category_id',
        'offer_id','click_url','click_value','url_original','producer_name','offer_shop_id','shop.name','shop_url',
        'shop_id','top_category_id','top_position','photo_id','description_html','properties','_metadata.url',
        '_metadata.facets.shops.url','_metadata.block_adsense','offer','block_adsense','_metadata.facets.categories.url'
    );

    public static $fieldsForSimilarProductsInProductPage = array('id','url','title','prices','photo_id');

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->converterProducts = new ProductsConverter();
        $this->converterProduct = new ProductConverter();
        $this->clientApi = $clientApi;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @param int $limit
     * @param $fields
     * @return Products
     */
    public function fetchProducts($limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setLimit($limit);
        $query->setFields($fields);

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchProductsByProducerName($producerName, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setProducerName($producerName);
        $query->setLimit($limit);
        $query->setFields($fields);

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param array $categoryIds
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchProductsByCategory(array $categoryIds, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds($categoryIds);
        $query->setLimit($limit);
        $query->setFields($fields);

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds(array($product->getCategoryId()));
        $query->setFilterPriceMinFrom($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields($fields);
        $query->setOrder('price_min', 'desc');

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds(array($product->getCategoryId()));
        $query->setFilterPriceMinTo($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields($fields);
        $query->setOrder('price_min', 'asc');

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param ProductsQuery $query
     * @return Products
     */
    public function fetchProductsByQuery(ProductsQuery $query)
    {
        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Product
     */
    public function fetchProductById($id, array $fields)
    {
        $query = new ProductQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setProductId($id);
        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProduct($objectsFromApi);
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return Products
     */
    public function fetchProductsByUrl($url, array $fields, $limit = 20)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter('url', $url);
        $query->setFields($fields);
        $query->setLimit($limit);
        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProducts($objectsFromApi);
    }

    /**
     * @param string $url
     * @param array $fields
     * @return Product
     */
    public function fetchProductByUrl($url, array $fields)
    {
        $query = new ProductQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setUrl($url);
        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertProduct($objectsFromApi);
    }

    /**
     * @param string $phrase
     * @return int
     */
    public function fetchCountProductsByPhrase($phrase)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields(array('id'));
        $query->setPhrase($phrase);

        $objectsFromApi = $this->clientApi->send($query);

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