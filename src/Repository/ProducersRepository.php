<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProducersFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProducersQuery;
use Nokaut\ApiKit\Collection\Producers;

class ProducersRepository extends RepositoryAbstract
{
    public static $fieldsAll = array(
        'id',
        'name'
    );

    /**
     * @param string $namePrefix
     * @param int $limit
     * @return Producers
     */
    public function fetchByNamePrefix($namePrefix, $limit)
    {
        $query = new ProducersQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->addFilter(new SingleWithOperator('name', 'prefix', $namePrefix));
        $query->setLimit($limit);

        $fetch = new ProducersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }
}