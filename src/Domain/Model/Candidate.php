<?php

namespace App\Domain\Model;

use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;
use Assert\Assertion;

class Candidate implements InterviewInterface
{
    /**
     * @param UserEntity          $user
     * @param BookDuration        $bookTimes
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $user, BookTimesInterface $bookTimes, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['user' => $user, 'date' => $bookTimes->getDate(), 'toDate' => $bookTimes->getToDate()]);
        Assertion::notEmpty($timeSheet, 'the requested time slot is already exist');
        $repository->removeUserUselessBookedTimes($user, $bookTimes->getDate(), $bookTimes->getToDate());
        /**
         * @todo: Add Other Interviewer Specific business rules
         */
        $timeSheet = new TimeSheetEntity();
        $timeSheet->setUser($user);
        $timeSheet->setTime($bookTimes);
        $repository->update($timeSheet);
    }
}
