<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 08:52
 */

namespace Nokaut\ApiKit\ClientApi;


use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;

interface ClientApiInterface {

    public function send(QueryBuilderInterface $query);
    /**
     * @param QueryBuilderInterface[] $queries
     * @return array
     */
    public function sendMulti(array $queries);
}