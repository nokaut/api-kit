<?php


namespace Nokaut\ApiKit\Collection;


use Nokaut\ApiKit\Entity\Metadata\OffersMetadata;
use Nokaut\ApiKit\Entity\Offer;
use PHPUnit\Framework\TestCase;

class OffersTest extends TestCase
{
    public function testClone()
    {
        $offer = new Offer();
        $offer->setId(11);
        $offers = new Offers(array($offer));

        $meta = new OffersMetadata();
        $meta->setTotal(111);

        $offers->setMetadata($meta);

        $offersClone = clone $offers;

        $this->assertNotEquals(spl_object_hash($offers->getMetadata()), spl_object_hash($offersClone->getMetadata()));
        $this->assertEquals($offers->getMetadata()->getTotal(), $offersClone->getMetadata()->getTotal());

        $this->assertNotEquals(spl_object_hash($offers->getItem(0)), spl_object_hash($offersClone->getItem(0)));
        $this->assertEquals(11, $offers->getItem(0)->getId());
        $this->assertEquals(11, $offersClone->getItem(0)->getId());

        $meta->setTotal(112);
        $this->assertNotEquals($offers->getMetadata()->getTotal(), $offersClone->getMetadata()->getTotal());

        $offer->setId(101);
        $this->assertEquals(101, $offers->getItem(0)->getId());
        $this->assertEquals(11, $offersClone->getItem(0)->getId());
    }
}
 