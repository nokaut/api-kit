<?php


namespace Nokaut\ApiKit\Entity\Shop;


use Nokaut\ApiKit\Entity\EntityAbstract;

class OpeningTime extends EntityAbstract
{
    const TIME_REGEXP = '/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/';

    /**
     * @var array
     */
    public $days = [
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun'
    ];

    /**
     * @var string
     */
    protected $day_from;

    /**
     * @var string
     */
    protected $day_to;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @return string
     */
    public function getDayFrom()
    {
        return $this->day_from;
    }

    /**
     * @param string $day_from
     */
    public function setDayFrom($day_from)
    {
        if ($this->isDayFormatValid($day_from)) {
            $this->day_from = $day_from;
        }
    }

    /**
     * @return string
     */
    public function getDayTo()
    {
        return $this->day_to;
    }

    /**
     * @param string $day_to
     */
    public function setDayTo($day_to)
    {
        if ($this->isDayFormatValid($day_to)) {
            $this->day_to = $day_to;
        }
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        if ($this->isTimeFormatValid($from)) {
            $this->from = $from;
        }
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        if ($this->isTimeFormatValid($to)) {
            $this->to = $to;
        }
    }

    /**
     * @param $day
     * @return bool
     */
    private function isDayFormatValid($day)
    {
        return in_array($day, $this->days);
    }

    /**
     * @param $hour
     * @return bool
     */
    private function isTimeFormatValid($hour)
    {
        return (bool)preg_match(self::TIME_REGEXP, $hour);
    }
}