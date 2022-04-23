<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoryFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Converter\Category\CategoriesGrouperConverter;

class CategoriesAsyncRepository extends CategoriesRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param \Nokaut\ApiKit\Config $config
     * @param ClientApiInterface $clientApi
     */
    public function __construct(Config $config, ClientApiInterface $clientApi)
    {
        parent::__construct($config, $clientApi);
        $this->asyncRepo = new AsyncRepository($clientApi);
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
     * @param array $fields
     * @return CategoriesFetch
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2, $fields = null)
    {
        $categoriesAsyncFetch = new Fetch($this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth, $fields), new CategoriesGrouperConverter(), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $parentId
     * @param array $fields
     * @return CategoriesFetch
     */
    public function fetchByParentId($parentId, $fields = null)
    {
        $categoriesAsyncFetch = new CategoriesFetch($this->prepareQueryForFetchByParentId($parentId, $fields), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $categoryId
     * @param array $fields
     * @return CategoryFetch
     */
    public function fetchById($categoryId, $fields = null)
    {
        $categoryAsyncFetch = new CategoryFetch($this->prepareQueryForFetchById($categoryId, $fields), $this->cache);
        $this->asyncRepo->addFetch($categoryAsyncFetch);
        return $categoryAsyncFetch;
    }

    /**
     * @param $categoryUrl
     * @param array $fields
     * @return CategoryFetch
     */
    public function fetchByUrl($categoryUrl, $fields = null)
    {
        $categoryAsyncFetch = new CategoryFetch($this->prepareQueryForFetchByUrl($categoryUrl, $fields), $this->cache);
        $this->asyncRepo->addFetch($categoryAsyncFetch);
        return $categoryAsyncFetch;
    }

    /**
     * @return CategoriesFetch
     */
    public function fetchMenuCategories()
    {
        $categoriesAsyncFetch = new CategoriesFetch($this->prepareQueryForFetchMenuCategories(), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param array $ids
     * @param int $limit
     * @param array $fields
     * @return CategoriesFetch
     */
    public function fetchCategoriesByIds(array $ids, $limit = 200, $fields = null)
    {
        $categoriesAsyncFetch = new CategoriesFetch($this->prepareQueryForFetchCategoriesByIds($ids, $limit, $fields), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param CategoriesQuery $query
     * @return CategoriesFetch
     */
    public function fetchCategoriesByQuery(CategoriesQuery $query)
    {
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->asyncRepo->addFetch($fetch);

        return $fetch;
    }

} 