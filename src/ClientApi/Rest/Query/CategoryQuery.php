<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.05.2014
 * Time: 10:58
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class CategoryQuery implements QueryBuilderInterface
{

    private $baseUrl;
    private $id;
    private $url;
    private $fields;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function createRequestPath()
    {
        $query = $this->baseUrl . $this->createMainPath() .
            $this->createFieldsPart();

        return $query;
    }

    private function createMainPath()
    {
        if (!empty($this->url)) {
            return "category?filter[url]=" . $this->url . "&";
        }
        if (!empty($this->id)) {
            return "categories/" . $this->id . "?";
        }
        throw new \InvalidArgumentException("set category URL or ID");
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