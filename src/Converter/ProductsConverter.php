<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 14:39
 */

namespace Nokaut\ApiKit\Converter;



use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facets\CategoryFacet;
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

        //todo convert to Entity/Metadata use MetadataConverter
        $products->setMetadata($object->_metadata);

        $this->setCategoriesFromMetadata($products);

        return $products;
    }

    public function setCategoriesFromMetadata(Products $products)
    {
        if (false == isset($products->getMetadata()->facets->categories)) {
            return;
        }
        $categories = $products->getMetadata()->facets->categories;
        $categoriesById = array();

        foreach ($categories as $category) {
            $categoryEntity = new CategoryFacet();
            $categoryEntity->setId($category->id);
            $categoryEntity->setTitle($category->title);
            $categoryEntity->setTotal($category->total);
            if (isset($category->url)) {
                $categoryEntity->setUrl($category->url);
            }
            $categoriesById[$category->id] = $categoryEntity;
        }

        foreach ($products as $product) {
            /** @var Product $product */
            if (isset($categoriesById[$product->getCategoryId()])) {
                $product->setCategory($categoriesById[$product->getCategoryId()]);
            }
        }

    }
} 