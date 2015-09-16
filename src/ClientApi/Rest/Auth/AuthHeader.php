<?php

/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 16.09.15
 * Time: 11:28
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Auth;

interface AuthHeader
{
    /**
     * @return array
     */
    public function getAuthHeader();
}