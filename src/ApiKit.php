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
use Nokaut\ApiKit\Repository\CategoriesRepository;
use Nokaut\ApiKit\Repository\ProductsRepository;

class ApiKit
{
    /**
     * @var Config
     */
    private $config;

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

        return new ProductsRepository($config->getApiUrl(), $restClientApi);
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

        return new CategoriesRepository($config->getApiUrl(), $restClientApi);
    }

    private function validate(Config $config)
    {
        $config->validate();
    }

    /**
     * @param Config $config
     * @return RestClientApi
     */
    private function getClientApi(Config $config)
    {
        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => $this->config->getApiAccessToken()
        );
        $oauth2->setAccessToken($accessToken);
        return new RestClientApi($config->getCache(), $config->getLogger(), $oauth2);
    }
}