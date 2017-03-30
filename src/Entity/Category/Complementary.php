<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 30.03.2017
 * Time: 11:27
 */

namespace Nokaut\ApiKit\Entity\Category;


class Complementary
{
    /**
     * @var string
     */
    protected $categoryId;
    /**
     * @var int - 1 to 10
     */
    protected $priority;

    /**
     * @return string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param string $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}
