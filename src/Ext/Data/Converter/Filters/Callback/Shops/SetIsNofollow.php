<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;
use Nokaut\ApiKit\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setShopsIsNofollow($shops, $products);
    }

    /**
     * @param Shops $shops
     * @param Products $products
     */
    protected function setShopsIsNofollow(Shops $shops, Products $products)
    {
        if (ProductsAnalyzer::filtersNofollow($products, $shops)) {
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                $shop->setIsNofollow(true);
            }

            return;
        }

        $selectedShopEntitiesCount = count($this->getSelectedShopEntities($shops));
        if ($selectedShopEntitiesCount >= 1) {
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                if ($shop->getIsFilter()) {
                    if ($selectedShopEntitiesCount <= 2) {
                        $shop->setIsNofollow(false);
                    } else {
                        $shop->setIsNofollow(true);
                    }
                } else {
                    $shop->setIsNofollow(true);
                }
            }

            return;
        }
    }

    /**
     * @param Shops $shops
     * @return Shop[]
     */
    protected function getSelectedShopEntities(Shops $shops)
    {
        return array_filter($shops->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        });
    }
}