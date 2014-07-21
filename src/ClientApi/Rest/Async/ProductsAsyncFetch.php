<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:21
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\Converter\ProductsConverter;

class ProductsAsyncFetch extends AsyncFetch
{

    public function __construct(ProductsQuery $query)
    {
        $this->query = $query;
        $this->converter = new ProductsConverter();
    }
}