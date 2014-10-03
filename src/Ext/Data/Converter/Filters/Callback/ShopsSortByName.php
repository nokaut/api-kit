<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class ShopsSortByName implements ShopsCallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setShopsSort($shops);
    }

    /**
     * @param Shops $shops
     */
    protected function setShopsSort(Shops $shops)
    {
        $entities = $shops->getEntities();

        usort($entities, function ($shop1, $shop2) {
            /** @var Shop $shop1 */
            /** @var Shop $shop2 */
            return strnatcmp(strtolower($shop1->getName()), strtolower($shop2->getName()));
        });

        $shops->setEntities($entities);
    }
}