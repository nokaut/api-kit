<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 08:19
 */

namespace Nokaut\ApiKit;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\ClientApi\Rest\RestClientApi;
use Nokaut\ApiKit\Repository\AsyncRepository;
use Nokaut\ApiKit\Repository\CategoriesAsyncRepository;
use Nokaut\ApiKit\Repository\CategoriesRepository;
use Nokaut\ApiKit\Repository\OffersAsyncRepository;
use Nokaut\ApiKit\Repository\OffersRepository;
use Nokaut\ApiKit\Repository\ProducersAsyncRepository;
use Nokaut\ApiKit\Repository\ProducersRepository;
use Nokaut\ApiKit\Repository\ProductsAsyncRepository;
use Nokaut\ApiKit\Repository\ProductsRepository;
use Nokaut\ApiKit\Repository\ShopsAsyncRepository;
use Nokaut\ApiKit\Repository\ShopsRepository;

class ApiKit
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Config $config
     * @return ProductsRepository
     */
    public function getProductsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProductsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ProductsAsyncRepository
     */
    public function getProductsAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProductsAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return CategoriesRepository
     */
    public function getCategoriesRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new CategoriesRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return CategoriesAsyncRepository
     */
    public function getCategoriesAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new CategoriesAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return OffersRepository
     */
    public function getOffersRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new OffersRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return OffersAsyncRepository
     */
    public function getOffersAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new OffersAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ProducersRepository
     */
    public function getProducersRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProducersRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ProducersRepository
     */
    public function getProducersAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProducersAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ShopsRepository
     */
    public function getShopsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ShopsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ShopsAsyncRepository
     */
    public function getShopsAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ShopsAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return AsyncRepository
     */
    public function getAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new AsyncRepository($restClientApi);
    }

    protected function validate(Config $config)
    {
        $config->validate();
    }

    /**
     * @param Config $config
     * @return RestClientApi
     */
    public function getClientApi(Config $config)
    {
        return new RestClientApi(
            $config->getLogger(),
            $config->getApiAccessToken(),
            $config->getApiUrl(),
            $config->getProxy()
        );
    }
}