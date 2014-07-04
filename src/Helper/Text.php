<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.04.2014
 * Time: 13:24
 */

namespace Nokaut\ApiKit\Helper;



class Text
{
    /**
     * Prepare string for url part
     * @param $string
     * @return mixed|string
     */
    public static function urlize($string)
    {
        $string = str_replace('®', '', $string);
        $string = @iconv("UTF-8", "ASCII//TRANSLIT", $string);
        $string = strtolower(preg_replace(array('/[^-a-zA-Z0-9\s]/', '/[\s]/'), array('', '-'), $string));
        $string = str_replace(array('---', '--'), '-', $string);
        return $string;
    }
} 