<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\CategoryFetch;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Converter\Category\CategoriesGrouperConverter;
use Nokaut\ApiKit\Entity\Category;

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
     * @return CategoriesFetch
     */
    public function fetchByParentIdWithChildren($parentId, $depth = 2)
    {
        $categoriesAsyncFetch = new Fetch($this->prepareQueryForFetchByParentIdWithChildren($parentId, $depth),new CategoriesGrouperConverter(), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $parentId
     * @return CategoriesFetch
     */
    public function fetchByParentId($parentId)
    {
        $categoriesAsyncFetch = new CategoriesFetch($this->prepareQueryForFetchByParentId($parentId), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

    /**
     * @param $categoryId
     * @return CategoryFetch
     */
    public function fetchById($categoryId)
    {
        $categoryAsyncFetch = new CategoryFetch($this->prepareQueryForFetchById($categoryId), $this->cache);
        $this->asyncRepo->addFetch($categoryAsyncFetch);
        return $categoryAsyncFetch;
    }

    /**
     * @param $categoryUrl
     * @return CategoryFetch
     */
    public function fetchByUrl($categoryUrl)
    {
        $categoryAsyncFetch = new CategoryFetch($this->prepareQueryForFetchByUrl($categoryUrl), $this->cache);
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
     * @return CategoriesFetch
     */
    public function fetchCategoriesByIds(array $ids)
    {
        $categoriesAsyncFetch = new CategoriesFetch($this->prepareQueryForFetchCategoriesByIds($ids), $this->cache);
        $this->asyncRepo->addFetch($categoriesAsyncFetch);
        return $categoriesAsyncFetch;
    }

} 