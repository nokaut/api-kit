<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:01
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKit\ClientApi\Rest\RestClientApi;
use Nokaut\ApiKit\Converter\CategoriesConverter;
use Nokaut\ApiKit\Converter\CategoryConverter;
use Nokaut\ApiKit\Converter\Category\CategoryGrouper;
use Nokaut\ApiKit\Collection\Sort\CategoriesSort;

class CategoriesRepository
{

    private static $fieldsAll = [
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
    ];

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
     * @var CategoriesConverter
     */
    private $converterCategories;
    /**
     * @var CategoryConverter
     */
    private $converterCategory;

    function __construct(Config $config)
    {
        $this->converterCategories = new CategoriesConverter();
        $this->converterCategory = new CategoryConverter();
        $this->config = $config;

        $oauth2 = new Oauth2Plugin();
        $oauth2->setAccessToken($this->config->getApiAccessToken());
        $this->productApiClient = new RestClientApi($this->config->getCache(), $this->config->getLogger(), $oauth2);
    }

    /**
     * @param int $parentId
     * @param int $depth - max depth is 2
     * @return Categories
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2)
    {
        $query = new CategoriesQuery($this->config->getApiUrl());
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        $query->setDepth($depth);
        $objectsFromApi = $this->productApiClient->send($query);

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
        $query = new CategoriesQuery($this->config->getApiUrl());
        $query->setFields($this->getFieldsWithoutDescription());
        $query->setParentId($parentId);
        $object = $this->productApiClient->send($query);
        return $this->convertCategories($object);
    }

    /**
     * @param $categoryId
     * @return Category
     */
    public function fetchById($categoryId)
    {
        $query = new CategoryQuery($this->config->getApiUrl());
        $query->setFields(self::$fieldsAll);
        $query->setId($categoryId);
        $object = $this->productApiClient->send($query);
        return $this->convertCategory($object);
    }

    /**
     * @param $categoryUrl
     * @return Category
     */
    public function fetchByUrl($categoryUrl)
    {
        $query = new CategoryQuery($this->config->getApiUrl());
        $query->setFields(self::$fieldsAll);
        $query->setUrl($categoryUrl);
        $object = $this->productApiClient->send($query);
        return $this->convertCategory($object);
    }

    public function fetchMenuCategories()
    {
        $query = new CategoriesQuery($this->config->getApiUrl());
        $query->setFields(self::getFieldsWithoutDescription());
        $query->setParentId(0);
        $query->setDepth(0);
        $object = $this->productApiClient->send($query);

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