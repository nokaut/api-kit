<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 08:52
 */

namespace Nokaut\ApiKit\ClientApi;


use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilder;

interface ClientApiInterface {

    public function send(QueryBuilder $query);
} 