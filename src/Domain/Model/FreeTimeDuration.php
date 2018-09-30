<?php
declare(strict_types=1);
namespace App\Domain\Model;

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
        if (!empty($toDate)) {
            $toDate = new \DateTime('Y-M-d', $toDate);
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
