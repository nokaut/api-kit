<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 07:59
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Entity\Category\Path;
use PHPUnit_Framework_TestCase;

class CategoryConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new CategoryConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Category $category */
        $category = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $this->assertEquals($value, $category->get($field));
            } else {
                switch ($field) {
                    case 'path':
                        $this->assertPath($correctObject->$field, $category->get($field));
                        break;
                    default:
                        $this->assertTrue(false, "not supported assert for field : " . $field);
                }
            }
        }
    }

    private function assertPath(array $correctObjectPath, array $categoryPath)
    {
        for ($i = 0; $i < count($correctObjectPath); ++$i) {
            foreach ($correctObjectPath[$i] as $field => $value) {
                /** @var Path $path */
                $path = $categoryPath[$i];
                $this->assertEquals($value, $path->get($field));
            }
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
                 "id": 10005,
                 "cpc_value": 0.2,
                 "depth": 2,
                 "description": "Zanim złożysz zamówienie - kliknij a następnie sprawdź oferty 1215 produktów z 6 sklepów w kategorii \"Alkohole\". W Nokaut.pl sprawdzisz produkty takich producentów jak: Żywiec, Multico, Monin. ",
                 "is_adult": null,
                 "is_visible": true,
                 "is_visible_on_homepage": true,
                 "title": "Alkohole",
                 "popularity": 76,
                 "parent_id": "6118",
                 "path": [
                  {
                   "id": 6118,
                   "title": "Delikatesy",
                   "url": "/delikatesy"
                  },
                  {
                   "id": 10005,
                   "title": "Alkohole",
                   "url": "/alkohole"
                  }
                 ],
                 "photo_id": "9f91883f268a2674c9166c9339e0eed6",
                 "subcategory_count": 0,
                 "url": "/alkohole",
                 "view_type": "list"
                }';
    }
} 