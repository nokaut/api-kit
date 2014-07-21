<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Async\CategoriesAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\CategoryAsyncFetch;
use Nokaut\ApiKit\Entity\Category;

class CategoriesAsyncRepository extends CategoriesRepository
{

    /**
     * @param string $apiBaseUrl
     */
    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @param int $parentId
     * @param int $depth
     * @return CategoriesAsyncFetch
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2)
    {
        return new CategoriesAsyncFetch($this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth));
    }

    /**
     * @param $parentId
     * @return CategoriesAsyncFetch
     */
    public function fetchByParentId($parentId)
    {
        return new CategoriesAsyncFetch($this->prepareQueryForFetchByParentId($parentId));
    }

    /**
     * @param $categoryId
     * @return CategoryAsyncFetch
     */
    public function fetchById($categoryId)
    {
        return new CategoryAsyncFetch($this->prepareQueryForFetchById($categoryId));
    }

    /**
     * @param $categoryUrl
     * @return CategoryAsyncFetch
     */
    public function fetchByUrl($categoryUrl)
    {
        return new CategoryAsyncFetch($this->prepareQueryForFetchByUrl($categoryUrl));
    }

    /**
     * @return CategoriesAsyncFetch
     */
    public function fetchMenuCategories()
    {
        return new CategoriesAsyncFetch($this->prepareQueryForFetchMenuCategories());
    }

    /**
     * @param array $ids
     * @return CategoriesAsyncFetch
     */
    public function fetchCategoriesByIds(array $ids)
    {
        return new CategoriesAsyncFetch($this->prepareQueryForFetchCategoriesByIds($ids));
    }

} 