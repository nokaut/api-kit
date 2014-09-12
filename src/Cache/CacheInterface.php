<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 03.07.2014
 * Time: 12:18
 */

namespace Nokaut\ApiKit\Cache;


interface CacheInterface {

    public function get($keyName, $lifetime = null);

    public function save($keyName = null, $content = null, $lifetime = null);

    public function delete($keyName);

}