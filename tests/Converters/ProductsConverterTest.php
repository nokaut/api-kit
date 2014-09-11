<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 09:25
 */

namespace Nokaut\ApiKit\Converter;


use PHPUnit_Framework_TestCase;

class ProductsConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new ProductsConverter();
        $correctObject = $this->getCorrectObject();
        $products = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->products), $products);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\CollectionAbstract', $products);
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\ProductsMetadata', $products->getMetadata());

        $this->assertNotEmpty($products->getCategories());
        foreach ($products->getCategories() as $category) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\CategoryFacet', $category);
        }

        $this->assertNotEmpty($products->getShops());
        foreach ($products->getShops() as $shop) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet', $shop);
        }

        $this->assertNotEmpty($products->getProducers());
        foreach ($products->getProducers() as $producer) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet', $producer);
        }

        $this->assertNotEmpty($products->getPrices());
        foreach ($products->getPrices() as $prices) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet', $prices);
        }

        $this->assertNotEmpty($products->getProperties());
        foreach ($products->getProperties() as $property) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet', $property);
        }

        $this->assertNotEmpty($products->getPhrase());
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\Facet\PhraseFacet', $products->getPhrase());

        $this->assertNotEmpty($products);
        foreach ($products as $product) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product', $product);
        }
    }

    public function testConvertWithoutFacets()
    {
        $cut = new ProductsConverter();
        $correctObject = $this->getCorrectObjectWithoutFacetAndMetadata();
        $products = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->products), $products);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\CollectionAbstract', $products);

        $this->assertEmpty($products->getMetadata());

        $this->assertEmpty($products->getCategories());

        $this->assertEmpty($products->getShops());

        $this->assertEmpty($products->getProducers());

        $this->assertEmpty($products->getPrices());

        $this->assertEmpty($products->getProperties());

        $this->assertEmpty($products->getPhrase());

        $this->assertNotEmpty($products);
    }

    private function getCorrectObjectWithoutFacetAndMetadata()
    {
        return json_decode('
        {
            "products": [
                {
                    "id": "51486f972da47c51ed01ffcf",
                    "title": "Nikon Coolpix S5200",
                    "prices": {
                        "min": 406.71,
                        "max": 789
                    }
                },
                {
                    "id": "50ffb8968e441a2a5c007f0b",
                    "title": "Nikon Coolpix S6500",
                    "prices": {
                        "min": 479,
                        "max": 869
                    }
                }
            ]
        }
        ');
    }

    private function getCorrectObject()
    {
        return json_decode('
        {
            "products": [
                {
                    "id": "51486f972da47c51ed01ffcf",
                    "title": "Nikon Coolpix S5200",
                    "prices": {
                        "min": 406.71,
                        "max": 789
                    }
                },
                {
                    "id": "50ffb8968e441a2a5c007f0b",
                    "title": "Nikon Coolpix S6500",
                    "prices": {
                        "min": 479,
                        "max": 869
                    }
                },
                {
                    "id": "503f0bf558c1ec116d000002",
                    "title": "Nikon Coolpix S01",
                    "prices": {
                        "min": 348,
                        "max": 457
                    }
                },
                {
                    "id": "51486fc282fff0377c0057a9",
                    "title": "Nikon Coolpix S3500",
                    "prices": {
                        "min": 352,
                        "max": 544
                    }
                },
                {
                    "id": "5025082ae4b0422cf60339a0",
                    "title": "Nikon Coolpix S2600",
                    "prices": {
                        "min": 375,
                        "max": 375
                    }
                },
                {
                    "id": "5025079ce4b0422cf60338f6",
                    "title": "Nikon Coolpix S3300",
                    "prices": {
                        "min": 419,
                        "max": 419
                    }
                },
                {
                    "id": "502507bde4b0422cf60338f9",
                    "title": "Nikon Coolpix S6300",
                    "prices": {
                        "min": 499,
                        "max": 529
                    }
                },
                {
                    "id": "51486f9a2da47c51ed01ffd0",
                    "title": "Nikon Coolpix S31",
                    "prices": {
                        "min": 379,
                        "max": 379
                    }
                },
                {
                    "id": "5305b41c8e441aafea00000b",
                    "title": "Nikon Coolpix S32",
                    "prices": {
                        "min": 371.8,
                        "max": 460.99
                    }
                },
                {
                    "id": "524e26f5b4fd33638d03287f",
                    "title": "Nikon D200 Grip (Cameron Sino)",
                    "prices": {
                        "min": 495,
                        "max": 495
                    }
                },
                {
                    "id": "524e26f0b4fd33bede032715",
                    "title": "Nikon D600 Grip MB-D14 (Cameron Sino)",
                    "prices": {
                        "min": 378,
                        "max": 378
                    }
                },
                {
                    "id": "524e26f2b4fd33638d03277d",
                    "title": "Nikon D800 Grip MB-D12 (Cameron Sino)",
                    "prices": {
                        "min": 378,
                        "max": 378
                    }
                },
                {
                    "id": "524e26f9b4fd33035603293c",
                    "title": "Nikon D80/D90 grip MB-D80 (Cameron Sino)",
                    "prices": {
                        "min": 342,
                        "max": 342
                    }
                },
                {
                    "id": "524e26f6b4fd33bede0328d4",
                    "title": "Nikon D7100 MB-D15 Grip (Cameron Sino)",
                    "prices": {
                        "min": 378,
                        "max": 378
                    }
                },
                {
                    "id": "524e26f3b4fd3303560327d7",
                    "title": "Nikon D300 / D700/D900 grip MB-D10 (Cameron Sino)",
                    "prices": {
                        "min": 347,
                        "max": 347
                    }
                },
                {
                    "id": "52e6090b82fff0736a00002f",
                    "title": "Nikon Coolpix S2800",
                    "prices": {
                        "min": 348.8,
                        "max": 438.99
                    }
                },
                {
                    "id": "52e6029a82fff07ec2000022",
                    "title": "Nikon Coolpix L30",
                    "prices": {
                        "min": 338.58,
                        "max": 389
                    }
                },
                {
                    "id": "52e20ec28e441aa7b8000001",
                    "title": "Nikon Coolpix S3600",
                    "prices": {
                        "min": 468.6,
                        "max": 592.99
                    }
                },
                {
                    "id": "5330565b3754b7ee9823436e",
                    "title": "Nikon Coolpix S32 biały",
                    "prices": {
                        "min": 407,
                        "max": 407
                    }
                },
                {
                    "id": "53306176902e517d56e84aa9",
                    "title": "Nikon Coolpix S32 różowy",
                    "prices": {
                        "min": 436,
                        "max": 436
                    }
                }
            ],
            "_metadata": {
                "total": 411,
                "quality": 100,
                "facets": { },
                "query": {
                    "phrase": "nikon",
                    "filter": {
                        "price_min": {
                            "in": [
                                {
                                    "lte": 500,
                                    "gte": 300
                                }
                            ]
                        }
                    },
                    "facet": {
                        "mincount": 1
                    },
                    "facet_range": { },
                    "offset": 0,
                    "limit": 20,
                    "sort": {
                        "category_sort3": "desc"
                     }
                }
            },
            "categories": [
                {
                    "id": 107,
                    "total": 24,
                    "url": "/aparaty-analogowe/",
                    "name": "Aparaty analogowe"
                },
                {
                    "id": 5795,
                    "total": 70,
                    "url": "/lustrzanki-cyfrowe/",
                    "name": "Lustrzanki cyfrowe"
                },
                {
                    "id": 5796,
                    "total": 431,
                    "url": "/aparaty-cyfrowe/",
                    "name": "Aparaty cyfrowe"
                },
                {
                    "id": 8444,
                    "total": 116,
                    "url": "/pozostale-aparaty-fotograficzne/",
                    "name": "Pozostałe aparaty fotograficzne"
                }

            ],
            "shops": [
                {
                    "id": 23239,
                    "name": "Saturn",
                    "total": 257,
                    "url": "/aparaty-fotograficzne/sklep:saturn-pl.html"
                },
                {
                    "id": 443,
                    "name": "Cyfrowe.pl",
                    "total": 243,
                    "url": "/aparaty-fotograficzne/sklep:cyfrowe-pl.html"
                }
            ],
            "producers": [
                {
                    "id": "nikon",
                    "name": "Nikon",
                    "total": 77,
                    "url": "/aparaty-fotograficzne/producent:nikon.html"
                },
                {
                    "id": "fujifilm",
                    "name": "Fujifilm",
                    "total": 74,
                    "url": "/aparaty-fotograficzne/producent:fujifilm.html"
                }
            ],
            "prices": [
                {
                    "min": 39.99,
                    "max": 424,
                    "total": 106,
                    "url": "/aparaty-cyfrowe/cena:39.99~424.00.html"
                },
                {
                    "min": 425.38,
                    "max": 741.7,
                    "total": 118,
                    "url": "/aparaty-cyfrowe/cena:425.38~741.70.html"
                },
                {
                    "min": 747,
                    "max": 1249,
                    "total": 112,
                    "url": "/aparaty-cyfrowe/cena:747.00~1249.00.html"
                },
                {
                    "min": 1259,
                    "max": 9900,
                    "total": 95,
                    "url": "/aparaty-cyfrowe/cena:1259.00~9900.00.html"
                }

            ],
            "properties": [
                {
                    "id": 18,
                    "name": "Zoom optyczny",
                    "unit": "x",
                    "values": [
                        {
                            "name": "5.0",
                            "total": 72,
                            "url": "/aparaty-cyfrowe/zoom-optyczny:5.00+x.html"
                        }
                    ]
                },
                {
                    "id": 2717,
                    "name": "Zoom cyfrowy",
                    "unit": "x",
                    "values": [
                        {
                            "name": "4.0",
                            "total": 101,
                            "url": "/aparaty-cyfrowe/zoom-cyfrowy:4.00+x.html"
                        },
                        {
                            "name": "5.0",
                            "total": 24,
                            "url": "/aparaty-cyfrowe/zoom-cyfrowy:5.00+x.html"
                        },
                        {
                            "name": "6.0",
                            "total": 18,
                            "url": "/aparaty-cyfrowe/zoom-cyfrowy:6.00+x.html"
                        },
                        {
                            "name": "2.0",
                            "total": 12,
                            "url": "/aparaty-cyfrowe/zoom-cyfrowy:2.00+x.html"
                        }
                    ]
                }
            ],
            "phrase": {
                "value": "lenovo",
                "url_in_template": "/laptopy/produkt:%s.html",
                "url_out": "/laptopy/"
            }
        }
        ');
    }
} 