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
use PHPUnit\Framework\TestCase;

class FetchTest extends TestCase
{
    public function testPrepareCacheKey()
    {
        $queryMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderAbstract')->getMock();
        $queryPath = '/path';
        $queryMock->expects($this->any())->method('createRequestPath')->willReturn($queryPath);
        $converterMock = $this->getMockBuilder('Nokaut\ApiKit\Converter\ConverterInterface')->getMock();
        $cache = new NullCache();

        $cut = new Fetch($queryMock, $converterMock, $cache);

        $this->assertEquals($cache->getPrefixKeyName() . md5($queryPath), $cut->prepareCacheKey());
    }
}