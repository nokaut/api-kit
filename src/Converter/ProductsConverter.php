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
use Nokaut\ApiKit\Converter\Metadata\Facet\PriceFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\ProducerFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\ShopFacetConverter;
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
        $products->setShops($this->convertShops($object));
        $products->setProducers($this->convertProducers($object));
        $products->setPrices($this->convertPrices($object));

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

    private function convertShops(\stdClass $object)
    {
        if (empty($object->shops)) {
            return array();
        }
        $shops = array();
        $converter = new ShopFacetConverter();

        foreach ($object->shops as $objectShop) {
            $shops[] = $converter->convert($objectShop);
        }
        return $shops;
    }

    private function convertProducers(\stdClass $object)
    {
        if (empty($object->producers)) {
            return array();
        }
        $producers = array();
        $converter = new ProducerFacetConverter();

        foreach ($object->producers as $objectProducer) {
            $producers[] = $converter->convert($objectProducer);
        }
        return $producers;
    }

    private function convertPrices(\stdClass $object)
    {
        if (empty($object->prices)) {
            return array();
        }
        $prices = array();
        $converter = new PriceFacetConverter();

        foreach ($object->prices as $objectPrice) {
            $prices[] = $converter->convert($objectPrice);
        }
        return $prices;
    }
} 