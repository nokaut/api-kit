<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:46
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


use Guzzle\Common\Exception\InvalidArgumentException;

class CategoriesQuery implements QueryBuilderInterface
{
    const MAX_DEPTH = 2;

    private $baseUrl;
    private $fields;
    private $filters = array();
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
        $this->filters['parent_id'] = intval($value);
    }

    /**
     * @param $value
     */
    public function setTitleLike($value)
    {
        $this->filters['title'] = array('operator' => 'like', 'value' => $value);
    }

    /**
     * @param $value
     */
    public function setTitleStrict($value)
    {
        $this->filters['title'] = array('operator' => 'eq', 'value' => $value);
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
        $this->filters['depth'] = intval($depth);
    }

    public function createRequestPath()
    {

        if (empty($this->filters) && empty($this->phrase)) {
            throw new \InvalidArgumentException('set filers for CategoriesQuery');
        }

        $query = $this->baseUrl . 'categories?' .
            $this->createFieldsPart() .
            $this->createFilterPart() .
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

    /**
     * @throws \InvalidArgumentException
     * @return string
     */
    private function createFilterPart()
    {
        $result = "";
        foreach ($this->filters as $field => $value) {
            if (is_array($value) && isset($value['operator'])) {
                $filerValue = urlencode($value['value']);
                $result .= "&filter[{$field}][{$value['operator']}]={$filerValue}";

            } else if (is_string($value) || is_numeric($value)) {
                $result .= "&filter[{$field}]={$value}";

            } else {
                throw new \InvalidArgumentException("invalid filter value " . var_export($value, true));
            }
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
} 