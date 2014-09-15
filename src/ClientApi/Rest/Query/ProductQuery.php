<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 01.04.2014
 * Time: 23:22
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

class ProductQuery extends QueryBuilderAbstract
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $productId;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
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

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function setUrl($url)
    {
        $this->addFilter(new Filter\Single('url', $url));
    }

    public function createRequestPath()
    {
        $query = $this->createMainPart() .
            $this->createFieldsPart() .
            ($this->createFilterPart() ? '&' . $this->createFilterPart() : '');

        return $query;
    }

    private function createFieldsPart()
    {
        if (empty($this->fields)) {
            throw new \InvalidArgumentException("fields can't be empty");
        }
        return "fields=" . implode(',', $this->fields);
    }

    /**
     * @return string
     */
    private function createMainPart()
    {
        if ($this->productId) {
            return $this->baseUrl . "product/" . $this->productId . "?";
        }
        return $this->baseUrl . "product?";
    }
} 