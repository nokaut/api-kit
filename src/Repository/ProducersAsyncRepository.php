<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.11.2015
 * Time: 14:18
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProducersFetch;
use Nokaut\ApiKit\Config;

class ProducersAsyncRepository extends ProducersRepository implements AsyncRepositoryInterface
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

    public function fetchByNamePrefix($namePrefix, array $fields, $limit)
    {
        $producersAsyncFetch = new ProducersFetch($this->prepareQueryByNamePrefix($namePrefix, $fields, $limit), $this->cache);
        $this->asyncRepo->addFetch($producersAsyncFetch);
        return $producersAsyncFetch;
    }

    public function fetchByIds(array $ids, array $fields)
    {
        $producersAsyncFetch = new ProducersFetch($this->prepareQueryByIds($ids, $fields), $this->cache);
        $this->asyncRepo->addFetch($producersAsyncFetch);
        return $producersAsyncFetch;
    }


}