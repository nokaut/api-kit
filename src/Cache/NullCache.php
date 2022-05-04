<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 03.07.2014
 * Time: 14:41
 */

namespace Nokaut\ApiKit\Cache;


class NullCache extends AbstractCache
{

    public function get($keyName, $lifetime = null)
    {
        return null;
    }

    public function save($keyName = null, $content = null, $lifetime = null)
    {
    }

    public function delete($keyName)
    {
    }

} 