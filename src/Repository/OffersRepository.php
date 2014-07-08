<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKit\Converter\OffersConverter;

class OffersRepository
{
    /**
     * @var ClientApiInterface
     */
    private $clientApi;
    /**
     * @var string
     */
    private $apiBaseUrl;
    /**
     * @var OffersConverter
     */
    private $converterOffers;

    public static $fieldsAll = array(
        'id', 'pattern_id', 'shop_id', 'shop_product_id', 'availability', 'category', 'description_html', 'title', 'price',
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
        $this->clientApi = $clientApi;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function getOffersByProductId($productId, array $fields, Sort $sort = null)
    {
        $query = new OffersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setProductId($productId);

        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
        }

        $objectsFromApi = $this->clientApi->send($query);

        return $this->convertOffers($objectsFromApi);
    }

    private function convertOffers($objectsFromApi)
    {
        return $this->converterOffers->convert($objectsFromApi);
    }
} 