<?php

namespace Nokaut\ApiKit\Entity\Product\Rating;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Rate extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var float
     */
    protected $rate;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $created;

    /**
     * @var string
     */
    protected $rater_name;

    /**
     * @var string
     */
    protected $ip_address;
}