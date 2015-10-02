<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

class ProductRatesQuery extends QueryBuilderAbstract
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
        return $this->baseUrl . "products/" . $this->productId . "/rates";
    }
}