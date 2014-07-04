<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 29.03.2014
 * Time: 20:55
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


interface QueryBuilderInterface
{

    const OPERATION_GTE = 'gte';
    const OPERATION_LTE = 'lte';

    public function createRequestPath();
}