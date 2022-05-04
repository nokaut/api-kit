<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:01
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoryFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Collection\Sort\CategoriesSort;
use Nokaut\ApiKit\Converter\Category\CategoriesGrouperConverter;
use Nokaut\ApiKit\Entity\Category;

class CategoriesRepository extends RepositoryAbstract
{

    public static $fieldsAll = array(
        'id',
        'cpc_value',
        'depth',
        'description',
        'is_adult',
        'is_visible',
        'is_visible_on_homepage',
        'title',
        'parent_id',
        'path',
        'photo_id',
        'popularity',
        'subcategory_count',
        'url',
        'view_type',
        'total',
        'prefix',
        'complementary'
    );

    /**
     * @return array
     */
    public function getFieldsWithoutDescription()
    {
        $fields = self::$fieldsAll;
        unset($fields['description']);
        return $fields;
    }

    /**
     * @param int $parentId
     * @param int $depth - max depth is 2
     * @param array $fields
     * @return Categories
     * @throws \Exception
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2, $fields = null)
    {
        $query = $this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth, $fields);
        $fetch = new Fetch($query, new CategoriesGrouperConverter(), $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $parentId
     * @param array $fields
     * @return Categories
     * @throws \Exception
     */
    public function fetchByParentId($parentId, $fields = null)
    {
        $query = $this->prepareQueryForFetchByParentId($parentId, $fields);
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $categoryId
     * @param array $fields
     * @return Category
     * @throws \Exception
     */
    public function fetchById($categoryId, $fields = null)
    {
        $query = $this->prepareQueryForFetchById($categoryId, $fields);
        $fetch = new CategoryFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $categoryUrl
     * @param array $fields
     * @return Category
     * @throws \Exception
     */
    public function fetchByUrl($categoryUrl, $fields = null)
    {
        $query = $this->prepareQueryForFetchByUrl($categoryUrl, $fields);
        $fetch = new CategoryFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    public function fetchMenuCategories()
    {
        $query = $this->prepareQueryForFetchMenuCategories();
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        /** @var Categories $categories */
        $categories = $fetch->getResult();
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    public function fetchCategoriesByIds(array $ids, $limit = 200, $fields = null)
    {
        $query = $this->prepareQueryForFetchCategoriesByIds($ids, $limit, $fields);
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        /** @var Categories $categories */
        $categories = $fetch->getResult();
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    /**
     * @param CategoriesQuery $query
     * @return Categories
     */
    public function fetchCategoriesByQuery(CategoriesQuery $query)
    {
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $parentId
     * @param $depth
     * @param array $fields
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchByParentIdWithChildren($parentId, $depth, $fields = null)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        if ($fields) {
            $query->setFields($fields);
        } else {
            $query->setFields($this->getFieldsWithoutDescription());
        }
        $query->setParentId($parentId);
        $query->setDepth($depth);
        return $query;
    }

    /**
     * @param $parentId
     * @param array $fields
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchByParentId($parentId, $fields = null)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        if ($fields) {
            $query->setFields($fields);
        } else {
            $query->setFields($this->getFieldsWithoutDescription());
        }
        $query->setParentId($parentId);
        return $query;
    }

    /**
     * @param $categoryId
     * @param array $fields
     * @return CategoryQuery
     */
    protected function prepareQueryForFetchById($categoryId, $fields = null)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        if ($fields) {
            $query->setFields($fields);
        } else {
            $query->setFields(self::$fieldsAll);
        }
        $query->setId($categoryId);
        return $query;
    }

    /**
     * @param $categoryUrl
     * @param array $fields
     * @return CategoryQuery
     */
    protected function prepareQueryForFetchByUrl($categoryUrl, $fields = null)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        if ($fields) {
            $query->setFields($fields);
        } else {
            $query->setFields(self::$fieldsAll);
        }
        $query->setUrl($categoryUrl);
        return $query;
    }

    /**
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchMenuCategories()
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields(self::getFieldsWithoutDescription());
        $query->setParentId(0);
        $query->setDepth(1);
        return $query;
    }

    /**
     * @param array $ids
     * @param int $limit
     * @param array $fields
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchCategoriesByIds(array $ids, $limit, $fields = null)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        if ($fields) {
            $query->setFields($fields);
        } else {
            $query->setFields($this->getFieldsWithoutDescription());
        }
        $query->setCategoryIds($ids);
        $query->setLimit($limit);
        return $query;
    }

}