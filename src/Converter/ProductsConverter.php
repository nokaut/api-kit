<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 14:39
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Converter\Metadata\Facet\CategoryFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\ProductsMetadataConverter;
use Nokaut\ApiKit\Entity\Product;

class ProductsConverter implements ConverterInterace
{

    /**
     * @param \stdClass $object
     * @return Products
     */
    public function convert(\stdClass $object)
    {
        $productConverter = new ProductConverter();
        $productsArray = array();
        foreach ($object->products as $productObject) {
            $productsArray[] = $productConverter->convert($productObject);
        }

        $products = new Products($productsArray);

        $products->setMetadata($this->convertMetadata($object));
        $products->setCategories($this->convertCategories($object));

        $this->setCategoriesFromMetadata($products);

        return $products;
    }

    public function setCategoriesFromMetadata(Products $products)
    {
        if ($products->getCategories()) {
            return;
        }
        $categories = $products->getCategories();
        $categoriesById = array();

        foreach ($categories as $category) {
            $categoriesById[$category->getId()] = $category;
        }

        foreach ($products as $product) {
            /** @var Product $product */
            if (isset($categoriesById[$product->getCategoryId()])) {
                $product->setCategory($categoriesById[$product->getCategoryId()]);
            }
        }

    }

    /**
     * @param \stdClass $object
     * @return mixed
     */
    private function convertMetadata(\stdClass $object)
    {
        if (isset($object->_metadata)) {
            $converterMetadata = new ProductsMetadataConverter();
            return $converterMetadata->convert($object->_metadata);
        }
        return null;
    }

    private function convertCategories(\stdClass $object)
    {
        if (empty($object->categories)) {
            return array();
        }
        $categories = array();
        $converter = new CategoryFacetConverter();

        foreach ($object->categories as $objectCategory) {
            $categories[] = $converter->convert($objectCategory);
        }
        return $categories;
    }
} 