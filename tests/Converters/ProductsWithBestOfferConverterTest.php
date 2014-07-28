<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 11:20
 */

namespace Nokaut\ApiKit\Converter;


use PHPUnit_Framework_TestCase;

class ProductsWithBestOfferConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new ProductsWithBestOfferConverter();
        $correctObject = $this->getCorrectObject();
        $products = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->products), $products);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\CollectionAbstract', $products);

        $this->assertNotEmpty($products);
        foreach ($products as $product) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\ProductWithBestOffer', $product);
        }
    }

    private function getCorrectObject()
    {
        return json_decode('{
            "products": [
                {
                    "id": "50ab37ba82fff088e8000ef2",
                    "title": "Apple iPad mini 16GB 4G",
                    "url": "tablety/apple-ipad-mini-16gb-4g",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=S*AHSNskKw$MUZpeVO5e8hNwcIF2gHEQNxf2Td*OA9psq2Ebmjvd7E*gWV9KoWjeY1ROPrgwwYDa5*8$GqVfwEtgm35W2hVpMsIQt7SCkqU_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "50b33df48e441ab790001a89",
                    "title": "Apple iPad mini 64GB 4G",
                    "url": "tablety/apple-ipad-mini-64gb-4g",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=DHei5EBGrW9RyRKRjBD2bACXBeHyLncSTuwI$LNIzlSovVSmImpReombMadXncQdg5qNubH3Xqgvu95cZmmhY*VSvRBAJG1jDrepEoAkhfY_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "53bfae0a82fff050590001ca",
                    "title": "Lenovo ThinkPad 8",
                    "url": "tablety/lenovo-thinkpad-8",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=hl5hkSAHMhWKYAXiZcl*HhOVWIVi5hkmgIPZhDEa9vnLZOdcq79gNeDkvRlzKuDIGWQcbfyzE8ePnUNTyok0WnScGfdeb0giE4KYfI8clYA_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "5137751782fff0973601a86e",
                    "title": "Toshiba AT300SE-101",
                    "url": "tablety/toshiba-at300se-101",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=L1n$8udSMtE4foq34pc9NCuGo$5C3vXoTgiT3KtXs*GBLs93HjKNkT5IduHxJ4RjXu13JcrEuU4CxX4Pa73pB4WY*O8CIJgHm4GF3VhGGeM_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "510690ac2da47c19f1000075",
                    "title": "Asus TF600T",
                    "url": "tablety/asus-tf600t"
                },
                {
                    "id": "53b693012da47c2735000206",
                    "title": "Kiano Elegance 10.1 by Zanetti",
                    "url": "tablety/kiano-elegance-10-1-by-zanetti",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=co0lnSdI3Yfj9UhvpCKJpjNHi7aQA$vdqjwws7eo*oLm0HckyM3T$V7LK*n$Qthki8TJb5tthvf6w4p3FPEJCTxAkYFPjlT8kcPatbAViCU_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "516e77058e441a7b12000114",
                    "title": "Toshiba AT300-105",
                    "url": "tablety/toshiba-at300-105",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=PLdZCNCjCJ*tN5p9S45hH6ILv1vDW2BwAkZDn3mHvbO7G7VUmGISMWRW9GPcBnuv1ne25VoMc655q99rxn5SbAAp18I2xEfhTuKME35Dwec_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "53bd0ce582fff0d35100020d",
                    "title": "Samsung Galaxy Tab 3 8.0 3G SM-T311",
                    "url": "tablety/samsung-galaxy-tab-3-8-0-3g-sm-t311",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=BNPQ9hF9uDyS7NiTJ$k9TyuBb48sDWDJsO8lQvI0pSzIxuAcxaT8LgijLbzfxP28nayYatH4ffuc40YKt7Q3CbB*CEI$NXxNGdC5QX38EGI_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "53bcf77582fff0d35100005d",
                    "title": "Samsung Galaxy Note Pro 12.2 LTE SM-P905",
                    "url": "tablety/samsung-galaxy-note-pro-12-2-lte-sm-p905",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=vGu7Zqa4rGLRoWq7ir42aN*njtLlzabOAP5dJFviMgNJkJ3C7nDS$jjfWBv*EEjHg9*3zIUsm$HhL*Ie7gcO7PiPPVCZyVX1UfMeV*ReoIo_P.API_1_1_category_sort3desc"
                    }
                },
                {
                    "id": "53bd0af02da47cb99900017e",
                    "title": "Samsung Galaxy Tab 3 7.0 3G SM-T211",
                    "url": "tablety/samsung-galaxy-tab-3-7-0-3g-sm-t211",
                    "offer_with_minimum_price": {
                        "click_url": "/Click/Offer/?click=ihjw2T2kxidT3ashN3JYXIlOv6c3oc2PnsLlocQOvLPY$rctEomgEBJBtpLvwEBH7fruh4S7NKDlvFUU4awCBFx*8DLlUoYAakkqJO7iM6M_P.API_1_1_category_sort3desc"
                    }
                }
            ]

        }');
    }
} 