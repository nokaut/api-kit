<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:53
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


use PHPUnit_Framework_TestCase;

class CategoriesQueryTest extends PHPUnit_Framework_TestCase
{
    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreateRequestPathWithParentId()
    {
        $cut = new CategoriesQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setParentId(12);

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories?fields=id,title&filter[parent_id]=12", $url);
    }

    public function testCreateRequestPathWithTitleLike()
    {
        $cut = new CategoriesQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setTitleStrict('Rowery górskie');

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories?fields=id,title&filter[title][eq]=Rowery+g%C3%B3rskie", $url);
    }

    public function testCreateRequestPathWithTitleStrict()
    {
        $cut = new CategoriesQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setTitleLike('Rowery górskie');

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories?fields=id,title&filter[title][like]=Rowery+g%C3%B3rskie", $url);
    }

    public function testCreateRequestPathWithPhrase()
    {
        $cut = new CategoriesQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setPhrase("rowery górskie");

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories?fields=id,title&phrase=rowery+g%C3%B3rskie", $url);
    }

    public function testCreateRequestPathWithIds()
    {
        $cut = new CategoriesQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setCategoryIds(array(1,45));

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories?fields=id,title&filter[id][in][]=1&filter[id][in][]=45", $url);
    }
}