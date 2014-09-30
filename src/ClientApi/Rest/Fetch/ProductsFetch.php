<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:21
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\Converter\ProductsConverter;

class ProductsFetch extends Fetch
{

    public function __construct(ProductsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProductsConverter(), $cache);
    }
}