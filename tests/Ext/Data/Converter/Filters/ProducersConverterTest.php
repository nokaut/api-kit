<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;
use PHPUnit\Framework\TestCase;
use stdClass;

class ProducersConverterTest extends TestCase
{
    public function testProducerConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $producersConverter = new ProducersConverter();
        $producers = $producersConverter->convert($products);

        $this->assertEquals('Producent', $producers->getName());
        $this->assertEquals(15, $producers->count());
        $this->assertEquals(count($products->getProducers()), $producers->count());
        $this->assertEquals('/laptopy/sklep:sklep-morele-net.html', $producers->getUrlOut());
        $this->assertEquals('/laptopy/sklep:sklep-morele-net,producent:%s.html', $producers->getUrlInTemplate());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers', $producers);

        foreach ($producers as $key => $producer) {
            /** @var Producer $producer */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer', $producer);
            $this->assertFalse($producer->getIsPopular());
            if ($key == 0) {
                $this->assertEquals('hp', $producer->getParam());
            }
        }
    }

    public function testProducerConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $producersConverter = new ProducersConverter();
        $producers = $producersConverter->convert($products, array(new SetIsPopular()));

        $this->assertEquals('Producent', $producers->getName());
        $this->assertEquals(15, $producers->count());
        $this->assertEquals(count($products->getProducers()), $producers->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers', $producers);

        foreach ($producers as $producer) {
            /** @var Producer $producer */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer', $producer);

            if (in_array($producer->getName(), array('HP', 'Lenovo', 'Asus', 'Toshiba', 'Dell', 'Acer',
                'Sony', 'MSI', 'Fujitsu'))
            ) {
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
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 