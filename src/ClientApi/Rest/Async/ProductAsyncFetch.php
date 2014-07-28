<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:26
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKit\Converter\ProductConverter;

class ProductAsyncFetch extends AsyncFetch
{

    public function __construct(ProductQuery $query)
    {
        $this->query = $query;
        $this->converter = new ProductConverter();
    }
}