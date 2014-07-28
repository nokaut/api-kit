<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 09:00
 */

namespace Nokaut\ApiKit\Converter\Metadata;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Converter\Metadata\Products\PagingConverter;
use Nokaut\ApiKit\Converter\Metadata\Products\QueryConverter;
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