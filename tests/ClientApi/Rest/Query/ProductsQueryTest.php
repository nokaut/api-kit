<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 10:38
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

use Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class ProductsQueryTest extends \PHPUnit_Framework_TestCase
{

    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreateRequestPath()
    {
        $cut = new ProductsQuery(self::$baseUrl);
        $cut->setFields(array('id,title'));
        $cut->addFilter(new Filter\Single('cecha', "jakieś tam filtr"));
        $cut->addFilter(new Filter\Single('property_9342', 23));
        $cut->addFacet('categories');
        $cut->setQuality(60);
        $cut->setLimit(100);
        $cut->setOffset(200);
        $cut->setFilterPriceMinFrom('0');
        $cut->setFilterPriceMinTo('100');
        $cut->setCategoryIds(array('12', '43'));
        $cut->setOrder('price_min', 'asc');
        $cut->setPhrase("fraza");
        $cut->setProducerName('producent sony');
        $cut->addFacetRange('price_min', 2);

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "products?" .
            "fields=id,title,_metadata&quality=60&phrase=fraza" .
            "&filter[cecha]=jakie%C5%9B+tam+filtr&filter[property_9342]=23" .
            "&filter[price_min][0][min]=0&filter[price_min][0][max]=100" .
            "&filter[category_ids][in][]=12&filter[category_ids][in][]=43" .
            "&filter[producer_name]=producent+sony" .
            "&facet[categories]=true&facet_range[price_min]=2&sort[price_min]=asc&limit=100&offset=200",
            $url);
    }
}
