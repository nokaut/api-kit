<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:23
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\Converter\CategoryConverter;

class CategoryFetch extends Fetch
{

    public function __construct(CategoryQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new CategoryConverter(), $cache);
    }
}