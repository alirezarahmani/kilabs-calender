<?php
declare(strict_types=1);
namespace App\Domain\Model;

use Assert\Assertion;

class FreeTimeDuration implements FreeTimesInterface
{
    private $date = null;
    private $toDate = null;

    public function __construct(
        FreeTimeFormatInterface $timeFormat,
        string $date,
        string $timeSlot,
        string $toTimeSlot = null,
        string $toDate = null
    ) {
        $date = new \DateTime($date);

        $this->date = $timeFormat->setTime($date, $timeSlot);
        if (!empty($toDate) && !empty($toTimeSlot)) {
            $toDate = new \DateTime($toDate);
            Assertion::greaterThan($toDate, $date, 'sorry it seems, to date is smaller than date');
            $this->toDate = $timeFormat->setTime($toDate, $toTimeSlot);
        } elseif (!empty($toTimeSlot) && empty($toDate)) {
            Assertion::greaterThan($toTimeSlot, $timeSlot, 'sorry it seems, to time is smaller than time');
            $this->toDate = $timeFormat->setTime($date, $toTimeSlot);
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
