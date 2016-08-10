<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.10.15
 * Time: 14:57
 */

namespace ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\NullCache;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;

class FetchTest extends \PHPUnit_Framework_TestCase
{
    public function testPrepareCacheKey()
    {
        $queryMock = $this->createMock('Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderAbstract');
        $queryPath = '/path';
        $queryMock->expects($this->any())->method('createRequestPath')->willReturn($queryPath);
        $converterMock = $this->createMock('Nokaut\ApiKit\Converter\ConverterInterface');
        $cache = new NullCache();

        $cut = new Fetch($queryMock, $converterMock, $cache);

        $this->assertEquals($cache->getPrefixKeyName() . md5($queryPath), $cut->prepareCacheKey());
    }
}