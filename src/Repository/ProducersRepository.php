<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProducersFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProducersQuery;
use Nokaut\ApiKit\Collection\Producers;

class ProducersRepository extends RepositoryAbstract
{
    const MAX_LIMIT = 100;

    public static $fieldsAutoComplete = array(
        'id',
        'name',
        'products_url'
    );
    public static $fieldsAll = array(
        'id',
        'name',
        'products_url',
        'description',
        'url',
        'url_logo'
    );

    /**
     * @param string $namePrefix
     * @param array $fields
     * @param int $limit
     * @return Producers
     */
    public function fetchByNamePrefix($namePrefix, array $fields, $limit)
    {
        $query = $this->prepareQueryByNamePrefix($namePrefix, $fields, $limit);

        $fetch = new ProducersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return Producers
     * @throws \Exception
     */
    public function fetchByIds(array $ids, array $fields)
    {
        $query = $this->prepareQueryByIds($ids, $fields);

        $fetch = new ProducersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $namePrefix
     * @param array $fields
     * @param $limit
     * @return ProducersQuery
     */
    protected function prepareQueryByNamePrefix($namePrefix, array $fields, $limit)
    {
        $query = new ProducersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new SingleWithOperator('name', 'prefix', $namePrefix));
        $query->setLimit($limit);
        return $query;
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return ProducersQuery
     */
    protected function prepareQueryByIds(array $ids, array $fields)
    {
        $query = new ProducersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setLimit(min(count($ids), self::MAX_LIMIT));
        $query->addFilter(new Single('id', join(',', $ids)));
        return $query;
    }
}