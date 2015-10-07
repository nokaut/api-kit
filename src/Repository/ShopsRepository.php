<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ShopsFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\ApiKit\ClientApi\Rest\Query\ShopsQuery;
use Nokaut\ApiKit\Collection\Shops;

class ShopsRepository extends RepositoryAbstract
{
    public static $fieldsAll = array(
        'id',
        'name',
        'products_url'
    );

    /**
     * @param string $namePrefix
     * @param int $limit
     * @return Shops
     */
    public function fetchByNamePrefix($namePrefix, $limit)
    {
        $query = new ShopsQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->addFilter(new SingleWithOperator('name', 'prefix', $namePrefix));
        $query->setLimit($limit);

        $fetch = new ShopsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }
}