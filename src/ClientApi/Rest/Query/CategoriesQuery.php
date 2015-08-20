<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:46
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class CategoriesQuery extends QueryBuilderAbstract
{
    const MAX_DEPTH = 2;

    protected $baseUrl;
    protected $fields;
    protected $phrase;
    protected $limit;

    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param int $value
     */
    public function setParentId($value)
    {
        $this->addFilter(new Filter\Single('parent_id', intval($value)));
    }

    /**
     * @param $value
     */
    public function setTitleLike($value)
    {
        $this->addFilter(new Filter\SingleWithOperator('title', 'like', $value));
    }

    /**
     * @param $value
     */
    public function setTitleStrict($value)
    {
        $this->addFilter(new Filter\SingleWithOperator('title', 'eq', $value));
    }

    /**
     * @param $value
     */
    public function setPhrase($value)
    {
        $this->phrase = $value;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param int $depth - max 2
     * @throws \InvalidArgumentException
     */
    public function setDepth($depth)
    {
        if ($depth > self::MAX_DEPTH) {
            throw new \InvalidArgumentException("depth cant be bigger than 2");
        }
        $this->addFilter(new Filter\Single('depth', intval($depth)));
    }

    public function setCategoryIds(array $ids)
    {
        $this->addFilter(new Filter\MultipleWithOperator('id', 'in', $ids));
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function createRequestPath()
    {

        if (!$this->getFilters() && empty($this->phrase)) {
            throw new \InvalidArgumentException('set filers for CategoriesQuery');
        }

        $query = $this->baseUrl . 'categories?' .
            $this->createFieldsPart() .
            ($this->createFilterPart() ? '&' . $this->createFilterPart() : '') .
            $this->createPhrasePart() .
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

    protected function createPhrasePart()
    {
        if (empty($this->phrase)) {
            return "";
        }
        return "&phrase=" . urlencode($this->phrase);
    }

    protected function createLimitPart()
    {
        if (empty($this->limit)) {
            return "";
        }
        return "&limit=" . (int)$this->limit;
    }
} 