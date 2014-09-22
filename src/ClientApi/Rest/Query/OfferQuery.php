<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 22.09.2014
 * Time: 11:33
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class OfferQuery  extends QueryBuilderAbstract
{
    private $baseUrl;
    /**
     * @var array
     */
    private $fields;
    /**
     * @var string
     */
    private $joinId;

    public function __construct($baseUrl)
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
     * @param string $joinId
     */
    public function setJoinId($joinId)
    {
        $this->joinId = $joinId;
    }

    public function createRequestPath()
    {
        if (empty($this->joinId)) {
            throw new \InvalidArgumentException("joinId can't be empty");
        }

        $query = $this->baseUrl . 'offers/' . $this->joinId . '?' .
            $this->createFieldsPart();

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
} 