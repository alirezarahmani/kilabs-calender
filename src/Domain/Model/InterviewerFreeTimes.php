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
     * @param FreeTimeDuration    $freeTimes
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $employer, FreeTimesInterface $freeTimes, RepositoryInterface $repository)
    {
        $timeSheet = $repository->findOneBy(['employer' => $employer, 'date' => $freeTimes->getDate(), 'toDate' => $freeTimes->getToDate()]);
        Assertion::null($timeSheet, 'the requested time slot is already exist');
        $repository->removeIntersectDuration($employer, $freeTimes->getDate(), $freeTimes->getToDate());
        /**
         * @todo: Add Other Interviewer Specific business rules
         */
        $timeSheet = new TimeSheetEntity();
        $timeSheet->setEmployer($employer);
        $timeSheet->setTime($freeTimes);
        $repository->update($timeSheet);
    }
}
