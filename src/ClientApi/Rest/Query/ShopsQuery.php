<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class ShopsQuery extends QueryBuilderAbstract
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function createRequestPath()
    {
        if (!$this->getFilters()) {
            throw new \InvalidArgumentException('set filers for ShopsQuery');
        }

        $filterPart = $this->createFilterPart();

        $query = $this->baseUrl . 'shops?' .
            $this->createFieldsPart() .
            ($filterPart ? '&' . $filterPart : '') .
            $this->createLimitPart();

        return $query;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function createFieldsPart()
    {
        if (empty($this->fields)) {
            throw new \InvalidArgumentException("fields can't be empty");
        }
        return "fields=" . implode(',', $this->fields);
    }

    /**
     * @return string
     */
    protected function createLimitPart()
    {
        if (empty($this->limit)) {
            return "";
        }
        return "&limit=" . (int)$this->limit;
    }
}