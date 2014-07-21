<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 15:00
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Cache\NullCache;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetches;
use Nokaut\ApiKit\ClientApi\Rest\Async\CategoryAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductsAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\ClientApi\Rest\RestClientApi;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\TestLogger;

class AsyncRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private static $baseUrl = "http://jboss1-web/api/v2/";
    /**
     * @var AsyncRepository
     */
    private $cut;

    /**
     * @before
     */
    public function init()
    {
        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => ""
        );
        $oauth2->setAccessToken($accessToken);
        $client = new RestClientApi(new NullCache(), new TestLogger(), $oauth2);

        $this->cut = new AsyncRepository($client);
    }

    public function testFetchAsync()
    {
        $fetches = new AsyncFetches();

        $query = new ProductsQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setLimit(1);
        $query->addFilter('urlll', "dddd");
        $fetch1 = new AsyncFetch($query, new ProductsConverter());
        $fetches->addFetch($fetch1);

        $query = new ProductsQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setLimit(1);
        $query->addFilter('url', "laptopy");
        $fetch2 = new AsyncFetch($query, new ProductsConverter());
        $fetches->addFetch($fetch2);

        $query = new ProductsQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setLimit(5);
        $query->addFilter('url', "rowery-gorskie");
        $fetch3 = new AsyncFetch($query, new ProductsConverter());
        $fetches->addFetch($fetch3);

        $this->cut->fetchAsync($fetches);


        $this->assertEmpty($fetch1->getResult());
        $this->assertNotEmpty($fetch2->getResult());
        $this->assertNotEmpty($fetch3->getResult());
    }

    public function testProductsCategoriesFetchAsync()
    {
        $fetches = new AsyncFetches();

        $query = new ProductsQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setLimit(1);
        $query->addFilter('urlll', "dddd");
        $fetch1 = new ProductsAsyncFetch($query);
        $fetches->addFetch($fetch1);

        $query = new ProductsQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setLimit(1);
        $query->addFilter('url', "laptopy");
        $fetch2 = new ProductsAsyncFetch($query);
        $fetches->addFetch($fetch2);

        $query = new CategoryQuery(self::$baseUrl);
        $query->setFields(array('id,title'));
        $query->setUrl("laptopy");
        echo $query->createRequestPath();
        $fetch3 = new CategoryAsyncFetch($query);
        $fetches->addFetch($fetch3);

        $this->cut->fetchAsync($fetches);


        $this->assertEmpty($fetch1->getResult());
        $this->assertNotEmpty($fetch2->getResult());
        $this->assertNotEmpty($fetch3->getResult());

    }
}