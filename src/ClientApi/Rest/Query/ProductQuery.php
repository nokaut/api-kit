<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 01.04.2014
 * Time: 23:22
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

class ProductQuery implements QueryBuilder
{

    private $baseUrl;
    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $filters = array();
    /**
     * @var string
     */
    private $productId;

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
        $url = str_replace('+', '%2b', $url); // fix for + in URL
        $this->filters['url'] = $url;
    }

    public function createRequestPath()
    {
        $query = $this->createMainPart() .
            $this->createFieldsPart() .
            $this->createFilterPart();

        return $query;
    }

    private function createFieldsPart()
    {
        if (empty($this->fields)) {
            throw new \InvalidArgumentException("fields can't be empty");
        }
        return "fields=" . implode(',', $this->fields);
    }

    private function createFilterPart()
    {
        $result = "";
        foreach ($this->filters as $field => $value) {
            $result .= "&filter[{$field}]={$value}";
        }
        return $result;
    }

    /**
     * @return string
     */
    private function createMainPart()
    {
        if($this->productId) {
            return $this->baseUrl . "product/" . $this->productId . "?";
        }
        return $this->baseUrl . "product?";
    }
} 