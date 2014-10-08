<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class SetIsNofollowTest extends \PHPUnit_Framework_TestCase
{
    public function testIsNofollow()
    {
        $products = new Products(array());
        $priceRanges = array();

        $priceRange = new PriceRange();
        $priceRange->setTotal(12);
        $priceRange->setMin(12);
        $priceRange->setMax(14);
        $priceRanges[] = $priceRange;

        $priceRange = new PriceRange();
        $priceRange->setTotal(12);
        $priceRange->setMin(12);
        $priceRange->setMax(14);
        $priceRanges[] = $priceRange;

        $priceRangesCollection = new PriceRanges($priceRanges);

        $callback = new SetIsNofollow();
        $callback($priceRangesCollection, $products);

        foreach ($priceRangesCollection as $priceRange) {
            /** @var PriceRange $priceRange */
            $this->assertTrue($priceRange->getIsNofollow());
        }
    }
}