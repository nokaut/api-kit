<?php

error_reporting(E_ALL | E_STRICT);

require dirname(__DIR__) . '/vendor/autoload.php';
require_once 'TestLogger.php';

$config = new \Nokaut\ApiKit\Config();
$config->setApiAccessToken('1/6692945412e595d6dc3da1370f49293b0becd005ece4197efd36db8659b78b6c3');
$config->setApiUrl('http://92.43.117.190/api/v2/');
$config->setLogger(new \Nokaut\ApiKit\TestLogger());

$apiKit = new \Nokaut\ApiKit\ApiKit($config);

//$productRepo = $apiKit->getProductsRepository();
//$product = $productRepo->fetchProductByUrl('tablety/apple-ipad-mini-16gb', ['id','title', 'prices']);

//$categoryRepo = $apiKit->getCategoriesRepository();
//$category = $categoryRepo->fetchByUrl('tablety', ['id','title']);

$productAsyncRepo = $apiKit->getProductsAsyncRepository();
$productFetch = $productAsyncRepo->fetchProductByUrl('tablety/apple-ipad-mini-16gb', ['id','title', 'prices']);

$categoryAsyncRepo = $apiKit->getCategoriesAsyncRepository();
$categoryFetch = $categoryAsyncRepo->fetchByUrl('tablety', ['id','title']);


$productQuery = new \Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery();
$productQuery->setFields(['id','title']);
$productQuery->setCategoryIds([127]);
$productFetch2 = $productAsyncRepo->fetchProductsByQuery($productQuery);

$productAsyncRepo->fetchAllAsync();

$productRepo = $apiKit->getProductsRepository();
$product = $productRepo->fetchProductsByQuery($productQuery);

//var_dump($productFetch->getResult(true), $categoryFetch->getResult(true), $productFetch2->getResult(true));

//var_dump($product, $category);
