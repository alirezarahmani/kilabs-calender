<?php

namespace App\Domain\Model;

class BookDuration implements BookTimesInterface
{
    private $date = null;
    private $toDate = null;

    public function __construct(
        BookingTimeFormatInterface $timeFormat,
        string $date,
        string $timeSlot,
        string $toTimeSlot = null,
        string $toDate = null
    ) {
        $date = \DateTime::createFromFormat('Y-M-d', $date);

        $this->date = $timeFormat->setTime($date, $timeSlot);
        if (!empty($toDate)) {
            $toDate = \DateTime::createFromFormat('Y-M-d', $toDate);
            $this->toDate = $timeFormat->setTime($toDate, $toTimeSlot);
        } elseif (!empty($toTimeSlot)) {
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
