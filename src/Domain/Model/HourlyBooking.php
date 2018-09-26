<?php

namespace App\Domain\Model;

use Assert\Assertion;

class HourlyBooking implements RulesInterface
{
    public function setTime(\DateTime $date, string $time): \DateTime
    {
        Assertion::regex(
            $time,
            '^(([0-1][0-9]|2[0-3]):[0-0][0-0](:[0-0][0-0])?)$',
            'wrong hourly timeSlot, please make sure you select 11:00 like format'
        );
        $time = explode(':', $time);
        $date->setTime($time[0], $time[1]);
        return $date;
    }
}