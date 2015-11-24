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

    public function fetchByNamePrefix($namePrefix, $limit)
    {
        $producersAsyncFetch = new ProducersFetch($this->prepareQueryByNamePrefix($namePrefix, $limit), $this->cache);
        $this->asyncRepo->addFetch($producersAsyncFetch);
        return $producersAsyncFetch;
    }


}