<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 10:04
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

use Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class ProductsQuery extends QueryBuilderAbstract
{
    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var array
     */
    private $order = array();

    /**
     * @var array
     */
    private $fields = array();
    /**
     * @var array
     */
    private $facets = array();
    /**
     * @var string
     */
    private $phrase;
    /**
     * @var int
     */
    private $quality;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var array
     */
    private $pricesFilter = array();
    /**
     * @var array
     */
    private $facetsRange = array();

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function setFilterPriceMinFrom($value)
    {
        $this->addFilter(new Filter\SingleWithIndexAndOperator('price_min', 0, 'min', $value));
    }

    public function setFilterPriceMinTo($value)
    {
        $this->addFilter(new Filter\SingleWithIndexAndOperator('price_min', 0, 'max', $value));
    }

    public function setOrder($field, $order)
    {
        $this->order[$field] = $order;
    }

    public function addFacet($name)
    {
        $this->facets[$name] = $name;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
        $this->fields[] = "_metadata";
    }

    public function setProducerName($producerName)
    {
        $this->addFilter(new Filter\Single('producer_name', $producerName));
    }

    public function setCategoryIds(array $categoryIds)
    {
        $this->addFilter(new Filter\MultipleWithOperator('category_ids', 'in', $categoryIds));
    }

    /**
     * @param string $phrase
     */
    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;
    }

    /**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        if ($offset > 10000) {
            $offset = 10000;
        }
        $this->offset = $offset;
    }

    public function addFacetRange($name, $value)
    {
        $this->facetsRange[$name] = $value;
    }

    public function createRequestPath()
    {
        $query = $this->baseUrl . 'products?' .
            $this->createFieldsPart() .
            $this->createQualityPart() .
            $this->createPhrasePart() .
            ($this->createFilterPart() ? '&' . $this->createFilterPart() : '') .
            $this->createFacetsPart() .
            $this->createFacetsRangePart() .
            $this->createSortPart() .
            $this->createLimitPart() .
            $this->createOffsetPart();

        return $query;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    private function createFieldsPart()
    {
        if (empty($this->fields)) {
            throw new \InvalidArgumentException("fields can't be empty");
        }
        return "fields=" . implode(',', $this->fields);
    }

    private function createSortPart()
    {
        $result = "";
        foreach ($this->order as $field => $value) {
            $result .= "&sort[{$field}]={$value}";
        }
        return $result;
    }

    private function createFacetsPart()
    {
        $result = "";
        foreach ($this->facets as $name) {
            $result .= "&facet[{$name}]=true";
        }
        return $result;
    }

    private function createFacetsRangePart()
    {
        $result = "";
        foreach ($this->facetsRange as $name => $value) {
            $result .= "&facet_range[{$name}]={$value}";
        }
        return $result;
    }

    private function createPhrasePart()
    {
        if (empty($this->phrase)) {
            return "";
        }
        return "&phrase=" . urlencode($this->phrase);
    }

    private function createQualityPart()
    {
        if (empty($this->quality)) {
            return "";
        }
        return "&quality=" . $this->quality;
    }

    private function createLimitPart()
    {
        if (empty($this->limit)) {
            return "";
        }
        return "&limit={$this->limit}";
    }

    private function createOffsetPart()
    {
        if (empty($this->offset)) {
            return "";
        }
        return "&offset={$this->offset}";
    }
} 