<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class SetIsActiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNotIsActive()
    {
        $products = new Products(array());

        $priceRanges = array();

        $priceRange = new PriceRange();
        $priceRange->setIsFilter(false);
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;

        $property = new PriceRanges($priceRanges);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());
    }

    public function testIsActive()
    {
        $products = new Products(array());

        $priceRanges = array();
        $priceRange = new PriceRange();
        $priceRange->setIsFilter(false);
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;
        $priceRange = new PriceRange();
        $priceRange->setIsFilter(true);
        $priceRanges[] = $priceRange;

        $property = new PriceRanges($priceRanges);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());

        /***/
        $priceRanges = array();
        $priceRange = new PriceRange();
        $priceRange->setIsFilter(true);
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;

        $property = new PriceRanges($priceRanges);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $priceRanges = array();
        $priceRange = new PriceRange();
        $priceRange->setIsFilter(true);
        $priceRanges[] = $priceRange;
        $priceRange = new PriceRange();
        $priceRange->setIsFilter(false);
        $priceRanges[] = $priceRange;
        $priceRanges[] = $priceRange;

        $property = new PriceRanges($priceRanges);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());
    }
}
 