<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.10.2014
 * Time: 11:20
 */

namespace Nokaut\ApiKit\ClientApi\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\InvalidRequestException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\UnprocessableEntityException;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RestClientApiTest extends TestCase
{
    public function testSendWithRetry()
    {
        $this->expectException(FatalResponseException::class);
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $request = $this->getMockBuilder('\GuzzleHttp\Psr7\Request')->disableOriginalConstructor()->getMock();
        $response = new Response(502, [], "{}");

        $exceptionFromApi = new BadResponseException('', $request, $response);
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(3))->method('send')->will($this->throwException($exceptionFromApi));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendWithRetryAndSecondSuccessful()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $request = $this->getMockBuilder('\GuzzleHttp\Psr7\Request')->disableOriginalConstructor()->getMock();
        $response = new Response(502, [], "{}");
        $responseSuccess = new Response(200, [], "{}");

        $exceptionFromApi = new BadResponseException('', $request, $response);
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(2))
            ->method('send')
            ->will(
                $this->onConsecutiveCalls($this->throwException($exceptionFromApi), $this->returnValue($responseSuccess))
            );

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendCorrectResponse()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = new Response(200, [], "{}");

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(1))->method('send')->will($this->returnValue($response));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendWithIncorrectResponse()
    {
        $this->expectException(FatalResponseException::class);
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $request = $this->getMockBuilder('\GuzzleHttp\Psr7\Request')->disableOriginalConstructor()->getMock();
        $response = new Response(500, [], "{}");

        $exceptionFromApi = new BadResponseException('', $request, $response);

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(1))->method('send')->will($this->throwException($exceptionFromApi));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendMultiWithRetry()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $cutMock = $this->prepareCutWithMockSendMultiProcess($loggerMock, $oauth2, $client);
        $cutMock->expects($this->exactly(3))->method('sendMultiProcess')->will($this->returnValue(true));

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);
    }

    public function testFunctionalitySendMultiWithRetry()
    {
        $this->expectException(FatalResponseException::class);
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $mockClientHandler = new MockHandler([
            new Response(502, [], '{}'),
            new Response(502, [], '{}'),
            new Response(502, [], '{}'),
        ]);

        $handler = HandlerStack::create($mockClientHandler);
        $client = new Client(['handler' => $handler]);

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);

        $fetches->getItem(0)->getResult(true);
    }

    public function testSendMultiWithRetryAndSecondSuccess()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $cutMock = $this->prepareCutWithMockSendMultiProcess($loggerMock, $oauth2, $client);
        $cutMock->expects($this->exactly(2))
            ->method('sendMultiProcess')
            ->will(
                $this->onConsecutiveCalls($this->returnValue(true), $this->returnValue(false))
            );

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);
    }

    public function testSendMultiWithoutRetry()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $mockClientHandler = new MockHandler([
            new Response(200, [], '{}')
        ]);

        $handler = HandlerStack::create($mockClientHandler);
        $client = new Client(['handler' => $handler]);

        $cutMock = $this->prepareCutWithMockSendMultiProcess($loggerMock, $oauth2, $client);
        $cutMock->expects($this->exactly(1))
            ->method('sendMultiProcess')
            ->will(
                $this->onConsecutiveCalls($this->returnValue(false), $this->returnValue(false))
            );

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);
    }

    public function testSendMultiException()
    {
        $this->expectException(InvalidRequestException::class);
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $mockClientHandler = new MockHandler([
            new Response(400, [], '{}'),
            new Response(400, [], '{}')
        ]);

        $handler = HandlerStack::create($mockClientHandler);
        $client = new Client(['handler' => $handler]);

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetches = $this->prepareFetches();
        $fetches->addFetch($this->prepareFetch());
        $cutMock->sendMulti($fetches);

        foreach ($fetches as $fetch) {
            /** @var Fetch $fetch */
            $this->assertInstanceOf('\Nokaut\ApiKit\ClientApi\Rest\Exception\InvalidRequestException', $fetch->getResponseException());
            $this->assertNull($fetch->getResult());
        }

        $fetches->getItem(0)->getResult(true);
    }

    public function testSendWithUnprocessableEntityException()
    {
        $this->expectException(UnprocessableEntityException::class);
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $mockClientHandler = new MockHandler([
            new Response(422, [], '{}'),
        ]);

        $handler = HandlerStack::create($mockClientHandler);
        $client = new Client(['handler' => $handler]);

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    /**
     * @return string
     */
    protected function prepareOauth()
    {
        return "1/token111accessoauth2";
    }

    /**
     * @param $loggerMock
     * @param $oauth2
     * @param $client
     * @return MockObject
     */
    protected function prepareCut($loggerMock, $oauth2, $client)
    {
        $cutMock = $this->clientApiMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\RestClientApi')
            ->setConstructorArgs([$loggerMock, $oauth2])
            ->setMethods(['getClient', 'logMulti', 'log'])
            ->getMock();
        $cutMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));
        return $cutMock;
    }

    /**
     * @param $loggerMock
     * @param $oauth2
     * @param $client
     * @return MockObject
     */
    protected function prepareCutWithMockSendMultiProcess($loggerMock, $oauth2, $client)
    {
        $cutMock = $this->clientApiMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\RestClientApi')
            ->setConstructorArgs([$loggerMock, $oauth2])
            ->setMethods(['getClient', 'logMulti', 'log', 'sendMultiProcess'])
            ->getMock();
        $cutMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));
        return $cutMock;
    }

    /**
     * @return Fetches
     */
    protected function prepareFetches()
    {
        $fetch = $this->prepareFetch();
        $fetches = new Fetches();
        $fetches->addFetch($fetch);
        return $fetches;
    }

    /**
     * @return ProductsFetch
     */
    protected function prepareFetch()
    {
        $cacheMock = $this->getMockBuilder('Nokaut\ApiKit\Cache\CacheInterface')->getMock();
        $queryMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery')->disableOriginalConstructor()->getMock();
        $queryMock->expects($this->any())->method('createRequestPath')->will($this->returnValue(''));
        $queryMock->expects($this->any())->method('getMethod')->will($this->returnValue('GET'));
        $queryMock->expects($this->any())->method('getHeaders')->will($this->returnValue([]));
        $queryMock->expects($this->any())->method('getBody')->will($this->returnValue(null));
        $converterMock = $this->getMockBuilder('Nokaut\ApiKit\Converter\ConverterInterface')->getMock();
        return new Fetch($queryMock, $converterMock, $cacheMock);
    }
} 