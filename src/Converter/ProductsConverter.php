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
use Nokaut\ApiKit\Converter\Metadata\Facet\PhraseFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\PriceFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\ProducerFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\PropertyFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\ShopFacetConverter;
use Nokaut\ApiKit\Converter\Metadata\ProductsMetadataConverter;
use Nokaut\ApiKit\Entity\Product;

class ProductsConverter implements ConverterInterface
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

        $this->convertMetadataAndFacets($object, $products);

        return $products;
    }

    /**
     * @param \stdClass $object
     * @param Products $products
     */
    protected function convertMetadataAndFacets(\stdClass $object, Products $products)
    {
        $products->setMetadata($this->convertMetadata($object));
        $products->setCategories($this->convertCategories($object));
        $products->setShops($this->convertShops($object));
        $products->setProducers($this->convertProducers($object));
        $products->setPrices($this->convertPrices($object));
        $products->setProperties($this->convertProperties($object));
        $products->setPhrase($this->convertPhrase($object));

        $this->setCategoriesFromMetadata($products);
    }

    protected function setCategoriesFromMetadata(Products $products)
    {
        if (!$products->getCategories()) {
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
    protected function convertMetadata(\stdClass $object)
    {
        if (isset($object->_metadata)) {
            $converterMetadata = new ProductsMetadataConverter();
            return $converterMetadata->convert($object->_metadata);
        }
        return null;
    }

    protected function convertCategories(\stdClass $object)
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

    protected function convertShops(\stdClass $object)
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

    protected function convertProducers(\stdClass $object)
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

    protected function convertPrices(\stdClass $object)
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

    protected function convertProperties(\stdClass $object)
    {
        if (empty($object->properties)) {
            return array();
        }
        $properties = array();
        $converter = new PropertyFacetConverter();

        foreach ($object->properties as $objectProperty) {
            $properties[] = $converter->convert($objectProperty);
        }
        return $properties;
    }

    protected function convertPhrase(\stdClass $object)
    {
        if (empty($object->phrase)) {
            return null;
        }
        $converter = new PhraseFacetConverter();

        $phrase = $converter->convert($object->phrase);

        return $phrase;
    }
} 