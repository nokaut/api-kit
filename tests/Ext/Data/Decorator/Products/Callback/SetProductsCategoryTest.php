<?php


namespace Nokaut\ApiKit\Ext\Data\Decorator\Products\Callback;


use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Converter\CategoriesConverter;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\Ext\Data\Decorator\Products\ProductsDecorator;
use PHPUnit\Framework\TestCase;
use stdClass;

class SetProductsCategoryTest extends TestCase
{
    public function testCallback()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $categoriesConverter = new CategoriesConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Categories $categories */
        $categories = $categoriesConverter->convert($correctObject);

        $productsDecorator = new ProductsDecorator();
        $productsDecorator->decorate($products, array(
            new SetProductsCategory($categories)
        ));

        /** @var $product Product */
        foreach ($products as $product) {
            $this->assertEquals(127, $product->getCategory()->getId());
            $this->assertEquals($product->getCategoryId(), $product->getCategory()->getId());
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

    /**
     * @return stdClass
     */
    private function getCorrectObject()
    {
        return json_decode($this->getCategoryFromApi());
    }

    private function getCategoryFromApi()
    {
        return '{
                 "categories": [
                  {
                   "id": 127,
                   "cpc_value": 0.24,
                   "depth": 2,
                   "description": "Telefony komórkowe renomowanych firm w naszej bazie ofert pozwolą Ci wybrać najkorzystniejszą cenę. Proponujemy najniższe ceny tego samego produktu!",
                   "is_adult": null,
                   "is_visible": true,
                   "is_visible_on_homepage": true,
                   "title": "Telefony komórkowe",
                   "parent_id": "686",
                   "total": "123",
                   "path": [
                    {
                     "id": 686,
                     "title": "Telefony i akcesoria",
                     "url": "/telefony-i-akcesoria"
                    },
                    {
                     "id": 687,
                     "title": "Telefony komórkowe",
                     "url": "/telefony-komorkowe"
                    }
                   ],
                   "photo_id": "07b3eb9f5a5f2b1ff4099a8c19aa6288",
                   "subcategory_count": 0,
                   "url": "/telefony-komorkowe",
                   "view_type": "picture"
                  },
                  {
                   "id": 689,
                   "cpc_value": 0.18,
                   "depth": 2,
                   "description": "Najkorzystniejsze oferty telefonów stacjonarnych znajdziesz w naszej bazie produktów. Stworzyliśmy zbiór ofert z renomowanych sklepów internetowych. Znajdź sklepy z najniższą ceną!",
                   "is_adult": null,
                   "is_visible": true,
                   "is_visible_on_homepage": true,
                   "title": "Telefony stacjonarne",
                   "parent_id": "686",
                   "total": "123",
                   "path": [
                    {
                     "id": 686,
                     "title": "Telefony i akcesoria",
                     "url": "/telefony-i-akcesoria"
                    },
                    {
                     "id": 689,
                     "title": "Telefony stacjonarne",
                     "url": "/telefony-stacjonarne"
                    }
                   ],
                   "photo_id": "24494c9416e6bedecd9ca79792c88542",
                   "subcategory_count": 0,
                   "url": "/telefony-stacjonarne",
                   "view_type": "list"
                  }
                 ]
                }';
    }
}