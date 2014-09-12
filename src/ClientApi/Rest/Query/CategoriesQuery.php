<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:46
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


use Guzzle\Common\Exception\InvalidArgumentException;

class CategoriesQuery extends QueryBuilderAbstract
{
    const MAX_DEPTH = 2;

    private $baseUrl;
    private $fields;
    private $phrase;

    public function __construct($baseUrl)
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
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     */
    public function setDepth($depth)
    {
        if ($depth > self::MAX_DEPTH) {
            throw new InvalidArgumentException("depth cant be bigger than 2");
        }
        $this->addFilter(new Filter\Single('depth', intval($depth)));
    }

    public function setCategoryIds(array $ids)
    {
        $this->addFilter(new Filter\MultipleWithOperator('id', 'in', $ids));
    }

    public function createRequestPath()
    {

        if (!$this->getFilters() && empty($this->phrase)) {
            throw new \InvalidArgumentException('set filers for CategoriesQuery');
        }

        $query = $this->baseUrl . 'categories?' .
            $this->createFieldsPart() .
            ($this->createFilterPart() ? '&' . $this->createFilterPart() : '') .
            $this->createPhrasePart();

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

    private function createPhrasePart()
    {
        if (empty($this->phrase)) {
            return "";
        }
        return "&phrase=" . urlencode($this->phrase);
    }
} 