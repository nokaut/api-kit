<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 27.06.2014
 * Time: 09:11
 */

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Converter\ApiConverter;
use Nokaut\ApiKit\Entity\Product\Shop;

class ShopConverter implements ApiConverter {

    public function convert(\stdClass $object)
    {
        $shop = new Shop();
        foreach ($object as $field => $value) {
            $shop->set($field, $value);
        }
        return $shop;
    }

} 