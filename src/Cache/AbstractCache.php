<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.10.15
 * Time: 14:54
 */

namespace Nokaut\ApiKit\Cache;


abstract class AbstractCache implements CacheInterface
{
    public function getPrefixKeyName()
    {
        return 'api-raw-response-';
    }

}