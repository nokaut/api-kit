<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:01
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\Converter\CategoriesConverter;
use Nokaut\ApiKit\Converter\CategoryConverter;
use Nokaut\ApiKit\Converter\Category\CategoriesGrouperConverter;
use Nokaut\ApiKit\Collection\Sort\CategoriesSort;

class CategoriesRepository
{

    /**
     * @var ClientApiInterface
     */
    protected $clientApi;
    /**
     * @var string
     */
    protected $apiBaseUrl;
    /**
     * @var CategoriesConverter
     */
    protected $converterCategories;
    /**
     * @var CategoryConverter
     */
    protected $converterCategory;

    protected static $fieldsAll = array(
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
        'view_type'
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
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->converterCategories = new CategoriesConverter();
        $this->converterCategory = new CategoryConverter();
        $this->clientApi = $clientApi;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @param int $parentId
     * @param int $depth - max depth is 2
     * @return Categories
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2)
    {
        $query = $this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth);
        $objectsFromApi = $this->clientApi->send($query);

        $converter = new CategoriesGrouperConverter();
        $categoriesGrouped = $converter->convert($objectsFromApi);
        return $categoriesGrouped;
    }

    /**
     * @param $parentId
     * @return Categories
     */
    public function fetchByParentId($parentId)
    {
        $query = $this->prepareQueryForFetchByParentId($parentId);
        $object = $this->clientApi->send($query);
        return $this->convertCategories($object);
    }

    /**
     * @param $categoryId
     * @return Category
     */
    public function fetchById($categoryId)
    {
        $query = $this->prepareQueryForFetchById($categoryId);
        $object = $this->clientApi->send($query);
        return $this->convertCategory($object);
    }

    /**
     * @param $categoryUrl
     * @return Category
     */
    public function fetchByUrl($categoryUrl)
    {
        $query = $this->prepareQueryForFetchByUrl($categoryUrl);
        $object = $this->clientApi->send($query);
        return $this->convertCategory($object);
    }

    public function fetchMenuCategories()
    {
        $query = $this->prepareQueryForFetchMenuCategories();
        $object = $this->clientApi->send($query);

        $categories = $this->convertCategories($object);
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    public function fetchCategoriesByIds(array $ids)
    {
        $query = $this->prepareQueryForFetchCategoriesByIds($ids);
        $object = $this->clientApi->send($query);

        $categories = $this->convertCategories($object);
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Category
     */
    protected function convertCategory(\stdClass $objectFromApi)
    {
        return $this->converterCategory->convert($objectFromApi);
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Categories
     */
    protected function convertCategories(\stdClass $objectFromApi)
    {
        return $this->converterCategories->convert($objectFromApi);
    }

    /**
     * @param $parentId
     * @param $depth
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchByParentIdWithChildren($parentId, $depth)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        $query->setDepth($depth);
        return $query;
    }

    /**
     * @param $parentId
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchByParentId($parentId)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        return $query;
    }

    /**
     * @param $categoryId
     * @return CategoryQuery
     */
    protected function prepareQueryForFetchById($categoryId)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->setId($categoryId);
        return $query;
    }

    /**
     * @param $categoryUrl
     * @return CategoryQuery
     */
    protected function prepareQueryForFetchByUrl($categoryUrl)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
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
        $query->setDepth(0);
        return $query;
    }

    /**
     * @param array $ids
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchCategoriesByIds(array $ids)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields(self::getFieldsWithoutDescription());
        $query->setCategoryIds($ids);
        return $query;
    }

}