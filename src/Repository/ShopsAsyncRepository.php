<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.11.2015
 * Time: 13:43
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ShopsFetch;
use Nokaut\ApiKit\Config;

class ShopsAsyncRepository extends ShopsRepository implements AsyncRepositoryInterface
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
        $shopsAsyncFetch = new ShopsFetch($this->prepareQueryByNamePrefix($namePrefix, $fields, $limit), $this->cache);
        $this->asyncRepo->addFetch($shopsAsyncFetch);
        return $shopsAsyncFetch;
    }

    public function fetchByIds(array $ids, array $fields)
    {
        $shopsAsyncFetch = new ShopsFetch($this->prepareQueryByIds($ids, $fields), $this->cache);
        $this->asyncRepo->addFetch($shopsAsyncFetch);
        return $shopsAsyncFetch;
    }


}