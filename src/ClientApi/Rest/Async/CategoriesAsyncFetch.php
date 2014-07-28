<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:22
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\Converter\CategoriesConverter;

class CategoriesAsyncFetch extends AsyncFetch
{

    public function __construct(CategoriesQuery $query)
    {
        $this->query = $query;
        $this->converter = new CategoriesConverter();
    }
}