<?php
error_reporting(E_ALL | E_STRICT);

require dirname(__DIR__) . '/vendor/autoload.php';
$r = new Nokaut\ApiKit\Entity\Category();

require_once 'TestLogger.php';

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') && class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

// backward compatibility
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}