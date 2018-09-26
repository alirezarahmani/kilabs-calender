<?php

namespace App\Domain\Model;

use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;

class Candidate implements InterviewInterface
{
    /**
     * @param UserEntity      $user
     * @param HourlyTimeSlot      $timeSlot
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $user, TimeSlotInterface $timeSlot, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['user' => $user, 'date' => $timeSlot->getDate()]);
        /**
         * @todo: Add Other Candidate Specific business rules
         */
        if (empty($timeSheet)) {
            $timeSheet = new TimeSheetEntity();
            $timeSheet->setUser($user);
        }
        $timeSheet->setTime($timeSlot);
        $repository->update($timeSheet);
    }
}