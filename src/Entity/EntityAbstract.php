<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 09.05.2014
 * Time: 15:20
 */

namespace Nokaut\ApiKit\Entity;


abstract class EntityAbstract
{

    public function set($fieldName, $value)
    {
        if (!property_exists($this, $fieldName)) {
            return;
        }
        $this->$fieldName = $value;
    }

    public function get($fieldName)
    {
        if (!property_exists($this, $fieldName)) {
            trigger_error('field ' . $fieldName . ' not defined', E_USER_NOTICE);
            return null;
        }
        return $this->$fieldName;
    }
} 