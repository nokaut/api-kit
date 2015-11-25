<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ShopsFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\MultipleWithOperator;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\ApiKit\ClientApi\Rest\Query\ShopsQuery;
use Nokaut\ApiKit\Collection\Shops;

class ShopsRepository extends RepositoryAbstract
{
    const MAX_LIMIT = 100;

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
        $query = $this->prepareQueryByNamePrefix($namePrefix, $limit);

        $fetch = new ShopsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param array $ids
     * @return Shops
     */
    public function fetchByIds(array $ids)
    {
        $query = $this->prepareQueryByIds($ids);

        $fetch = new ShopsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $namePrefix
     * @param $limit
     * @return ShopsQuery
     */
    protected function prepareQueryByNamePrefix($namePrefix, $limit)
    {
        $query = new ShopsQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->addFilter(new SingleWithOperator('name', 'prefix', $namePrefix));
        $query->setLimit($limit);
        return $query;
    }

    /**
     * @param array $ids
     * @return ShopsQuery
     */
    protected function prepareQueryByIds(array $ids)
    {
        $query = new ShopsQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->setLimit(min(count($ids), self::MAX_LIMIT));
        $query->addFilter(new MultipleWithOperator('id', 'in', $ids));
        return $query;
    }
}