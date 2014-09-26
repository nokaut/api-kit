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
    private $id;

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
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function createRequestPath()
    {
        if (empty($this->id)) {
            throw new \InvalidArgumentException("id can't be empty");
        }

        $query = $this->baseUrl . 'offers/' . $this->id . '?' .
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