<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\ApiKit\ClientApi\Rest\Query\OfferQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKit\Converter\OfferConverter;
use Nokaut\ApiKit\Converter\OffersConverter;

class OffersRepository
{
    /**
     * @var ClientApiInterface
     */
    protected $clientApi;
    /**
     * @var string
     */
    protected $apiBaseUrl;
    /**
     * @var OffersConverter
     */
    protected $converterOffers;

    public static $fieldsAll = array(
        'id', 'join_id', 'pattern_id', 'shop_id', 'shop_product_id', 'availability', 'category', 'description_html', 'title', 'price',
        'producer', 'promo', 'url', 'warranty', 'category_id', 'photo_id', 'photo_ids', 'cpc_value', 'expires_at', 'blocked_at',
        'click_value', 'visible', 'properties', 'description', 'click_url', 'shop.id', 'shop.name', 'shop.opineo_rating',
        'shop.url_logo', 'shop.high_quality', '_metadata'
    );

    public static $fieldsForProductPage = array(
        'id', 'join_id', 'pattern_id', 'title', 'price', 'availability', 'url', 'click_url', 'click_value', 'photo_id',
        'category_id', 'category_cpc', 'max_cpc', 'valid_cpa', 'weight', 'description', 'warranty', 'shop', 'shop_product_id',
        'shop_id', 'shop', 'shop.id', 'shop.url_logo', 'shop.name', 'shop.high_quality', 'shop.opineo_rating', '_metadata'
    );

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->converterOffers = new OffersConverter();
        $this->converterOffer = new OfferConverter();
        $this->clientApi = $clientApi;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function fetchOffersByProductId($productId, array $fields, Sort $sort = null)
    {
        $query = $this->prepareQueryForFetchOffersByProductId($productId, $fields, $sort);

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertOffers($objectsFromApi);
    }

    public function fetchOfferById($id, array $fields)
    {
        $query = $this->prepareQueryForFetchOfferById($id, $fields);

        $objectsFromApi = $this->clientApi->send($query);
        return $this->convertOffer($objectsFromApi);
    }

    public function fetchOffersByShopId($shopId, array $fields, $limit = 20, Sort $sort = null)
    {
        $query = $this->prepareQueryForFetchOffersByShopId($shopId, $fields, $limit, $sort);

        $objectsFromApi = $this->clientApi->send($query);
        return $this->convertOffers($objectsFromApi);
    }

    protected function convertOffers($objectsFromApi)
    {
        return $this->converterOffers->convert($objectsFromApi);
    }

    protected function convertOffer($objectFromApi)
    {
        return $this->converterOffer->convert($objectFromApi);
    }

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @return OffersQuery
     */
    protected function prepareQueryForFetchOffersByProductId($productId, array $fields, Sort $sort = null)
    {
        $query = new OffersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setProductId($productId);

        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
        }
        return $query;
    }

    /**
     * @param $id
     * @param array $fields
     * @return OfferQuery
     */
    protected function prepareQueryForFetchOfferById($id, array $fields)
    {
        $query = new OfferQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setId($id);

        return $query;
    }

    /**
     * @param $shopId
     * @param array $fields
     * @param int $limit
     * @param Sort $sort
     * @return OffersQuery
     */
    protected function prepareQueryForFetchOffersByShopId($shopId, array $fields, $limit, Sort $sort = null)
    {
        $query = new OffersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new Single('shop_id', $shopId));
        $query->setLimit($limit);
        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
        }

        return $query;
    }
} 