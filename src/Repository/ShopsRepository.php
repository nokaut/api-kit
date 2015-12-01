<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ShopsFetch;
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
        'products_url',
        'url_logo'
    );

    public static $fieldsAutoComplete = array(
        'id',
        'name',
        'products_url'
    );

    /**
     * @param string $namePrefix
     * @param array $fields
     * @param int $limit
     * @return Shops
     * @throws \Exception
     */
    public function fetchByNamePrefix($namePrefix, array $fields, $limit)
    {
        $query = $this->prepareQueryByNamePrefix($namePrefix, $fields, $limit);

        $fetch = new ShopsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return Shops
     * @throws \Exception
     */
    public function fetchByIds(array $ids, array $fields)
    {
        $query = $this->prepareQueryByIds($ids, $fields);

        $fetch = new ShopsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $namePrefix
     * @param array $fields
     * @param $limit
     * @return ShopsQuery
     */
    protected function prepareQueryByNamePrefix($namePrefix, array $fields, $limit)
    {
        $query = new ShopsQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new SingleWithOperator('name', 'prefix', $namePrefix));
        $query->setLimit($limit);
        return $query;
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return ShopsQuery
     */
    protected function prepareQueryByIds(array $ids, array $fields)
    {
        $query = new ShopsQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setLimit(min(count($ids), self::MAX_LIMIT));
        $query->addFilter(new Single('id', join(',', $ids)));
        return $query;
    }
}