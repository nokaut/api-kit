<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 14:42
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class OffersQuery extends QueryBuilderAbstract
{
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
    private $order = array();

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @param $field - price, vickrey, opinions
     * @param $order - asc, desc
     */
    public function setOrder($field, $order)
    {
        $this->order[$field] = $order;
    }

    public function createRequestPath()
    {
        $query = $this->baseUrl . $this->createMainPart() .
            $this->createFieldsPart() .
            ($this->createFilterPart() ? '&' . $this->createFilterPart() : '') .
            $this->createLimitPart() .
            $this->createSortPart();

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

    private function createLimitPart()
    {
        $limitAndOffset = "";
        if ($this->limit) {
            $limitAndOffset .= "&limit={$this->limit}";
        }
        if ($this->offset) {
            $limitAndOffset .= "&offset={$this->offset}";
        }
        return $limitAndOffset;
    }

    private function createSortPart()
    {
        $result = "";
        foreach ($this->order as $field => $value) {
            $result .= "&sort[{$field}]={$value}";
        }
        return $result;
    }

    /**
     * @return string
     */
    protected function createMainPart()
    {
        if ($this->productId) {
            return 'products/' . $this->productId .'/offers?';
        }
        return "offers?";
    }
} 