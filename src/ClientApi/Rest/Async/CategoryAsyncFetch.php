<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:23
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\Converter\CategoryConverter;

class CategoryAsyncFetch extends AsyncFetch
{

    public function __construct(CategoryQuery $query)
    {
        $this->query = $query;
        $this->converter = new CategoryConverter();
    }
}