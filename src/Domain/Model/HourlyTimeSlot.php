<?php

namespace App\Domain\Model;

use Assert\Assertion;

class HourlyTimeSlot implements TimeSlotInterface
{
    private $rule;
    private $date = null;
    private $toDate = null;


    public function __construct(RulesInterface $rule)
    {
       $this->rule = $rule;
    }

    public function bookTimes(\DateTime $date, string $timeSlot, string $toTimeSlot = null, \DateTime $toDate = null):void
    {
        $this->date = $this->rule->setTime($date, $timeSlot);
        $this->toDate = null;
        if (!empty($toDate)) {
            $this->toDate = $this->rule->setTime($toDate, $toTimeSlot);
        } elseif (!empty($toTimeSlot)) {
            $this->toDate = $this->rule->setTime($date, $toTimeSlot);
        }
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getToDate()
    {
        return $this->toDate;
    }
}
