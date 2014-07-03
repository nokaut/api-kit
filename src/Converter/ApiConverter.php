<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 29.03.2014
 * Time: 23:23
 */

namespace Nokaut\ApiKit\Converter;


interface ApiConverter
{

    public function convert(\stdClass $object);
} 