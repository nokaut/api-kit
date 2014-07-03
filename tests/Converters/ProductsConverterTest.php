<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 09:25
 */

namespace Nokaut\ApiKit\Converter;


use PHPUnit_Framework_TestCase;

class ProductsConverterTest extends PHPUnit_Framework_TestCase {

    public function testConvert()
    {
        $cut = new ProductsConverter();
        $correctObject = $this->getCorrectObject();
        $products = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->products), $products);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\AbstractCollection', $products);
        foreach ($products as $product) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product', $product);
        }
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
                    "sort": { }
                }
            }

        }
        ');
    }
} 