<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 10:04
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class ProductsQuery implements QueryBuilder
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
    private $filters = array();
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
     * @var array
     */
    private $categoriesIds = array();
    /**
     * @var int
     */
    private $quality;
    /**
     * @var int
     */
    private $limit;
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
        $this->pricesFilter['price_min']['min'] = $value;
    }

    public function setFilterPriceMinTo($value)
    {
        $this->pricesFilter['price_min']['max'] = $value;
    }

    public function setOrder($field, $order)
    {
        $this->order[$field] = $order;
    }

    public function addFilter($filter, $searchValue)
    {
        $this->filters[$filter] = $searchValue;
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
        $this->filters['producer_name'] = $producerName;
    }

    public function setCategoryIds(array $categoryIds)
    {
        $this->categoriesIds = $categoryIds;
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
            $this->createFilterPart() .
            $this->createPricesFilterPart() .
            $this->createFacetsPart() .
            $this->createFacetsRangePart() .
            $this->createSortPart() .
            $this->createCategoryPart() .
            $this->createLimitPart();

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

    private function createFilterPart()
    {
        $result = "";
        foreach ($this->filters as $field => $value) {
            if (is_array($value)) {
                $valueEscaped = urlencode($value['value']);
                $result .= "&filter[{$field}][{$value['operation']}]={$valueEscaped}";
            } else {
                $valueEscaped = urlencode($value);
                $result .= "&filter[{$field}]={$valueEscaped}";
            }
        }
        return $result;
    }

    private function createPricesFilterPart()
    {
        $result = "";
        foreach ($this->pricesFilter as $priceType => $operator) {
            foreach($operator as $operatorType => $value) {
                $result .= "&filter[{$priceType}][0][{$operatorType}]={$value}";
            }
        }
        return $result;
    }

    private function createCategoryPart()
    {
        $result = "";
        foreach ($this->categoriesIds as $categoryId) {
            $result .= "&filter[category_ids][in][]={$categoryId}";
        }
        return $result;
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
        if(empty($this->quality)) {
            return "";
        }
        return "&quality=".$this->quality;
    }

    private function createLimitPart()
    {
        if (empty($this->limit)) {
            return "";
        }
        return "&limit={$this->limit}";
    }
} 