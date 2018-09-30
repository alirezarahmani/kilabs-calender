<?php
declare(strict_types=1);
namespace App\Domain\Model;

use Assert\Assertion;

class HourlyTimeFormat implements FreeTimeFormatInterface
{
    public function setTime(\DateTime $date, string $time): \DateTime
    {
        Assertion::regex(
            $time,
            '/^(?:2[0-3]|[01][0-9]):([0-0][0-0]):([0-0][0-0])$/',
            'wrong hourly timeSlot, please make sure you select 11:00:00 like format'
        );
        $time = explode(':', $time);
        $date->setTime($time[0], '00', '00');
        return $date;
    }
}
