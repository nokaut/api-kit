<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 03.07.2014
 * Time: 14:12
 */
error_reporting(E_ALL | E_STRICT);

require dirname(__DIR__) . '/vendor/autoload.php';
$r = new Nokaut\ApiKit\Entity\Category();

require_once 'TestLogger.php';