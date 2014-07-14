<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:23
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Products;

class ProductsWithBestOfferConverter extends ProductsConverter
{
    /**
     * @param \stdClass $object
     * @return Products
     */
    public function convert(\stdClass $object)
    {
        $productConverter = new ProductWithBestOfferConverter();
        $productsArray = array();
        foreach ($object->products as $productObject) {
            $productsArray[] = $productConverter->convert($productObject);
        }

        $products = new Products($productsArray);

        $this->convertMetadataAndFacets($object, $products);

        return $products;
    }
} 