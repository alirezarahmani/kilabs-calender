<?php

namespace App\Domain\Model;

use Assert\Assertion;

class HourlyBooking implements RulesInterface
{
    /** @var \DateTime */
    private $date;

    /** @var ?\DateTime */
    private $toDate;

    public static function newInstance(array $inputs): HourlyBooking
    {
        if (!isset($inputs['toDate']) && isset($inputs['toTimeSlot'])) {
            return new self($inputs['fromDateTime'], $inputs['fromTimeSlot'], $inputs['toTimeSlot']);
        } elseif (isset($inputs['toDate']) && isset($inputs['toTimeSlot'])) {
            return new self($inputs['fromDateTime'], $inputs['fromTimeSlot'], $inputs['toTimeSlot'], $inputs['toDate']);
        }
        return new self($inputs['fromDateTime'], $inputs['fromTimeSlot']);
    }

    public function __construct(\DateTime $fromDateTime, string $fromTimeSlot, string $toTimeSlot = null, \DateTime $toDate = null)
    {
        $this->date = $this->setTime($fromDateTime, $fromTimeSlot);
        if (!empty($toTimeSlot)) {
            if (empty($toDate)) {
                $this->toDate = $this->setTime($fromDateTime, $toTimeSlot);;
            } else {
                $this->toDate = $this->setTime($toDate, $toTimeSlot);;
            }
         }
    }

    private function setTime(\DateTime $date, string $time): \DateTime
    {
        Assertion::regex($time, '^(([0-1][0-9]|2[0-3]):[0-0][0-0](:[0-0][0-0])?)$', 'wrong hourly timeSlot, please make sure you select 11:00 like format');
        $time = explode(':', $time);
        $date->setTime($time[0], $time[1]);
        return $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getToDate(): ?\DateTime
    {
        return $this->toDate;
    }
}