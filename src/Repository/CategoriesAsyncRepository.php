<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\CategoriesAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\CategoryAsyncFetch;
use Nokaut\ApiKit\Converter\Category\CategoriesGrouperConverter;
use Nokaut\ApiKit\Entity\Category;

class CategoriesAsyncRepository extends CategoriesRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->apiBaseUrl = $apiBaseUrl;
        $this->asyncRepo = AsyncRepository::getInstance($clientApi);
    }

    public function clearAllFetches()
    {
        $this->asyncRepo->clearAllFetches();
    }

    public function fetchAllAsync()
    {
        $this->asyncRepo->fetchAllAsync();
    }

    /**
     * @param int $parentId
     * @param int $depth
     * @return CategoriesAsyncFetch
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2)
    {
        $categoriesAsyncFetch = new AsyncFetch($this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth),new CategoriesGrouperConverter());
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $parentId
     * @return CategoriesAsyncFetch
     */
    public function fetchByParentId($parentId)
    {
        $categoriesAsyncFetch = new CategoriesAsyncFetch($this->prepareQueryForFetchByParentId($parentId));
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $categoryId
     * @return CategoryAsyncFetch
     */
    public function fetchById($categoryId)
    {
        $categoryAsyncFetch = new CategoryAsyncFetch($this->prepareQueryForFetchById($categoryId));
        $this->asyncRepo->addFetch($categoryAsyncFetch);
        return $categoryAsyncFetch;
    }

    /**
     * @param $categoryUrl
     * @return CategoryAsyncFetch
     */
    public function fetchByUrl($categoryUrl)
    {
        $categoryAsyncFetch = new CategoryAsyncFetch($this->prepareQueryForFetchByUrl($categoryUrl));
        $this->asyncRepo->addFetch($categoryAsyncFetch);
        return $categoryAsyncFetch;
    }

    /**
     * @return CategoriesAsyncFetch
     */
    public function fetchMenuCategories()
    {
        $categoriesAsyncFetch = new CategoriesAsyncFetch($this->prepareQueryForFetchMenuCategories());
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param array $ids
     * @return CategoriesAsyncFetch
     */
    public function fetchCategoriesByIds(array $ids)
    {
        $categoriesAsyncFetch = new CategoriesAsyncFetch($this->prepareQueryForFetchCategoriesByIds($ids));
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

} 