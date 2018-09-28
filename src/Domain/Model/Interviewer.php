<?php

namespace App\Domain\Model;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;
use Assert\Assertion;

class Interviewer implements InterviewInterface
{
    /**
     * @param EmployerEntity      $employer
     * @param BookDuration        $bookTimes
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $employer, BookTimesInterface $bookTimes, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['employer' => $employer, 'date' => $bookTimes->getDate(), 'toDate' => $bookTimes->getToDate()]);
        Assertion::notEmpty($timeSheet, 'the requested time slot is already exist');
        $repository->removeEmployerUselessBookedTimes($employer, $bookTimes->getDate(), $bookTimes->getToDate());
        /**
         * @todo: Add Other Interviewer Specific business rules
         */
        $timeSheet = new TimeSheetEntity();
        $timeSheet->setEmployer($employer);
        $timeSheet->setTime($bookTimes);
        $repository->update($timeSheet);
    }
}
