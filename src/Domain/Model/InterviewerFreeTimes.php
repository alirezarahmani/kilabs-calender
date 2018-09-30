<?php
declare(strict_types=1);
namespace App\Domain\Model;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;
use Assert\Assertion;

class InterviewerFreeTimes implements InterviewInterface
{
    /**
     * @param EmployerEntity      $employer
     * @param FreeTimeDuration    $bookTimes
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $employer, FreeTimesInterface $bookTimes, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['employer' => $employer, 'date' => $bookTimes->getDate(), 'toDate' => $bookTimes->getToDate()]);
        Assertion::null($timeSheet, 'the requested time slot is already exist');
        $repository->removeIntersectDuration($employer, $bookTimes->getDate(), $bookTimes->getToDate());
        /**
         * @todo: Add Other Interviewer Specific business rules
         */
        $timeSheet = new TimeSheetEntity();
        $timeSheet->setEmployer($employer);
        $timeSheet->setTime($bookTimes);
        $repository->update($timeSheet);
    }
}
