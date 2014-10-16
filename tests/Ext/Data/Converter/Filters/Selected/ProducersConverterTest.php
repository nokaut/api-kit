<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class ProducersConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testProducerConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy-with-filters'));

        $producersConverter = new ProducersConverter();
        $producers = $producersConverter->convert($products);

        $this->assertEquals(1, $producers->count());
        $this->assertEquals('Producent', $producers->getName());
        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers', $producers);

        foreach ($producers as $producer) {
            /** @var Producer $producer */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer', $producer);
            $this->assertFalse($producer->getIsPopular());
        }
    }

    public function testProducerConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy-with-filters'));

        $producersConverter = new ProducersConverter();
        $producers = $producersConverter->convert($products, array(new SetIsPopular()));

        $this->assertEquals(1, $producers->count());
        $this->assertEquals('Producent', $producers->getName());
        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers', $producers);

        foreach ($producers as $producer) {
            /** @var Producer $producer */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer', $producer);

            if (in_array($producer->getName(), array('Asus'))) {
                $this->assertTrue($producer->getIsPopular());
            } else {
                $this->assertFalse($producer->getIsPopular());
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 