<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:26
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKit\Converter\ProductConverter;

class ProductFetch extends Fetch
{

    public function __construct(ProductQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProductConverter(), $cache);
    }

}