<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;
use PHPUnit\Framework\TestCase;
use stdClass;

class ProducersConverterTest extends TestCase
{
    public function testCache()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy-with-filters'));

        // facets
        $producersConverter = new \Nokaut\ApiKit\Ext\Data\Converter\Filters\ProducersConverter();
        $producers = $producersConverter->convert($products);
        $this->assertEquals(6, $producers->count());

        // selected
        $producersConverter = new ProducersConverter();
        $producersSelected = $producersConverter->convert($products);

        // nie moga sie zmienic po konwersji selected
        $this->assertEquals(6, $producers->count());
        $this->assertEquals(1, $producersSelected->count());

        // nie moga byc wspoldzielone przez referencje te same obiekty
        $this->assertNotEquals(spl_object_hash($producers->getItem(4)), spl_object_hash($producersSelected->getItem(0)));
    }

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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 