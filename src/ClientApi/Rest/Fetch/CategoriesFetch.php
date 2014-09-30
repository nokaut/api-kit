<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:22
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\Converter\CategoriesConverter;

class CategoriesFetch extends Fetch
{

    public function __construct(CategoriesQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new CategoriesConverter(), $cache);
    }
}