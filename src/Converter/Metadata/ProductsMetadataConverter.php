<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 09:00
 */

namespace Nokaut\ApiKit\Converter\Metadata;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Converter\Metadata\Products\CategoriesConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\PagingConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\PricesConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\ProducersConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\PropertiesConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\QueryConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\ShopsConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\SortConverter;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;

class ProductsMetadataConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $productsMetadata = new ProductsMetadata();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($productsMetadata, $field, $value);
            } else {
                $productsMetadata->set($field, $value);
            }

        }
        return $productsMetadata;
    }

    private function convertSubObject(ProductsMetadata $metadata, $field, $value)
    {
        switch ($field) {
            case 'paging':
                $pagingConverter = new PagingConverter();
                $metadata->setPaging($pagingConverter->convert($value));
                break;
            case 'sorts':
                $sorts = $this->convertSorts($value);
                $metadata->setSorts($sorts);
                break;
            case 'query':
                $queryConverter = new QueryConverter();
                $query = $queryConverter->convert($value);
                $metadata->setQuery($query);
                break;
            case 'categories':
                $categoriesConverter = new CategoriesConverter();
                $categories = $categoriesConverter->convert($value);
                $metadata->setCategories($categories);
                break;
            case 'shops':
                $shopsConverter = new ShopsConverter();
                $shops = $shopsConverter->convert($value);
                $metadata->setShops($shops);
                break;
            case 'producers':
                $producersConverter = new ProducersConverter();
                $producers = $producersConverter->convert($value);
                $metadata->setProducers($producers);
                break;
            case 'prices':
                $pricesConverter = new PricesConverter();
                $prices = $pricesConverter->convert($value);
                $metadata->setPrices($prices);
                break;
            case 'properties':
                $propertiesConverter = new PropertiesConverter();
                $properties = $propertiesConverter->convert($value);
                $metadata->setProperties($properties);
                break;
        }
    }

    /**
     * @param \stdClass $value
     * @return array
     */
    private function convertSorts($value)
    {
        $sorts = array();
        $sortsConverter = new SortConverter();
        foreach ($value as $sortObject) {
            $sorts[] = $sortsConverter->convert($sortObject);
        }
        return $sorts;
    }
} 