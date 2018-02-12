<?php


namespace Nokaut\ApiKit\Entity\Shop;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Company extends EntityAbstract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $phone_fax;

    /**
     * @var string
     */
    protected $vatin;

    /**
     * @var string
     */
    protected $regon;

    /**
     * @var Address
     */
    protected $address;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return string
     */
    public function getPhoneFax()
    {
        return $this->phone_fax;
    }

    /**
     * @param string $phone_fax
     */
    public function setPhoneFax($phone_fax)
    {
        $this->phone_fax = $phone_fax;
    }

    /**
     * @return string
     */
    public function getVatin()
    {
        return $this->vatin;
    }

    /**
     * @param string $vatin
     */
    public function setVatin($vatin)
    {
        $this->vatin = $vatin;
    }

    /**
     * @return string
     */
    public function getRegon()
    {
        return $this->regon;
    }

    /**
     * @param string $regon
     */
    public function setRegon($regon)
    {
        $this->regon = $regon;
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
}