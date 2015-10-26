<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

class ProductRateQuery extends QueryBuilderAbstract
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $rateId;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @param string $rateId
     */
    public function setRateId($rateId)
    {
        $this->rateId = $rateId;
    }

    public function createRequestPath()
    {
        $query = $this->createMainPart();

        return $query;
    }

    /**
     * @return string
     */
    private function createMainPart()
    {
        return $this->baseUrl . "products/" . $this->productId . "/rates/" . $this->rateId;
    }
}