<?php

namespace App\Domain\Model;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;

class Interviewer implements InterviewInterface
{
    /**
     * @param EmployerEntity      $employer
     * @param HourlyTimeSlot      $timeSlot
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $employer, TimeSlotInterface $timeSlot, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['employer' => $employer, 'date' => $timeSlot->getDate()]);
        /**
         * @todo: Add Other Interviewer Specific business rules
         */
        if (empty($timeSheet)) {
            $timeSheet = new TimeSheetEntity();
            $timeSheet->setEmployer($employer);
        }
        $timeSheet->setTime($timeSlot);
        $repository->update($timeSheet);
    }
}