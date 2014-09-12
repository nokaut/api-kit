<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:08
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Category;
use PHPUnit_Framework_TestCase;

class CategoriesConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new CategoriesConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Category[] $categories */
        $categories = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->categories), $categories);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\CollectionAbstract', $categories);
        foreach ($categories as $category) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Category', $category);
        }
    }

    /**
     * @return \stdClass
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
                   "id": 687,
                   "cpc_value": 0.24,
                   "depth": 2,
                   "description": "Telefony komórkowe renomowanych firm w naszej bazie ofert pozwolą Ci wybrać najkorzystniejszą cenę. Proponujemy najniższe ceny tego samego produktu!",
                   "is_adult": null,
                   "is_visible": true,
                   "is_visible_on_homepage": true,
                   "title": "Telefony komórkowe",
                   "parent_id": "686",
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