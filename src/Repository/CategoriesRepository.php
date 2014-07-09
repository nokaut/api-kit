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
use Nokaut\ApiKit\Converter\Category\CategoryGrouper;
use Nokaut\ApiKit\Collection\Sort\CategoriesSort;

class CategoriesRepository
{

    /**
     * @var ClientApiInterface
     */
    private $clientApi;
    /**
     * @var string
     */
    private $apiBaseUrl;
    /**
     * @var CategoriesConverter
     */
    private $converterCategories;
    /**
     * @var CategoryConverter
     */
    private $converterCategory;

    private static $fieldsAll = array(
        'id',
        'cpc_value',
        'depth',
        'description',
        'is_adult',
        'is_visible',
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
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        $query->setDepth($depth);
        $objectsFromApi = $this->clientApi->send($query);

        $categories = $this->convertCategories($objectsFromApi);

        $grouperToTreeData = new CategoryGrouper();
        $categoriesGrouped = $grouperToTreeData->joinCategoriesWithChildren($categories);
        return $categoriesGrouped;
    }

    /**
     * @param $parentId
     * @return Categories
     */
    public function fetchByParentId($parentId)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        $object = $this->clientApi->send($query);
        return $this->convertCategories($object);
    }

    /**
     * @param $categoryId
     * @return Category
     */
    public function fetchById($categoryId)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->setId($categoryId);
        $object = $this->clientApi->send($query);
        return $this->convertCategory($object);
    }

    /**
     * @param $categoryUrl
     * @return Category
     */
    public function fetchByUrl($categoryUrl)
    {
        $query = new CategoryQuery($this->apiBaseUrl);
        $query->setFields(self::$fieldsAll);
        $query->setUrl($categoryUrl);
        $object = $this->clientApi->send($query);
        return $this->convertCategory($object);
    }

    public function fetchMenuCategories()
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields(self::getFieldsWithoutDescription());
        $query->setParentId(0);
        $query->setDepth(0);
        $object = $this->clientApi->send($query);

        $categories = $this->convertCategories($object);
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    public function fetchCategoriesByIds(array $ids)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields(self::getFieldsWithoutDescription());
        $query->setCategoryIds($ids);
        $object = $this->clientApi->send($query);

        $categories = $this->convertCategories($object);
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Category
     */
    private function convertCategory(\stdClass $objectFromApi)
    {
        return $this->converterCategory->convert($objectFromApi);
    }

    /**
     * @param \stdClass $objectFromApi
     * @return Categories
     */
    private function convertCategories(\stdClass $objectFromApi)
    {
        return $this->converterCategories->convert($objectFromApi);
    }

}