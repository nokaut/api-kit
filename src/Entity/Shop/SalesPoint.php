<?php


namespace Nokaut\ApiKit\Entity\Shop;


use Nokaut\ApiKit\Entity\EntityAbstract;

class SalesPoint extends EntityAbstract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var OpeningTime[]
     */
    protected $opening_times = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return OpeningTime[]
     */
    public function getOpeningTimes()
    {
        return $this->opening_times;
    }

    /**
     * @param OpeningTime[] $opening_times
     */
    public function setOpeningTimes($opening_times)
    {
        $this->opening_times = $opening_times;
    }
}