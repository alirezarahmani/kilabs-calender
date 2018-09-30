<?php
declare(strict_types=1);
namespace App\Domain\Model;

use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Repository\TimeSheetRepository;
use Assert\Assertion;

class CandidateFreeTimes implements InterviewInterface
{
    /**
     * @param UserEntity          $user
     * @param FreeTimeDuration    $bookTimes
     * @param TimeSheetRepository $repository
     */
    public function apply(EntityInterface $user, FreeTimesInterface $bookTimes, RepositoryInterface $repository):void
    {
        $timeSheet = $repository->findOneBy(['user' => $user, 'date' => $bookTimes->getDate(), 'toDate' => $bookTimes->getToDate()]);
        Assertion::null($timeSheet, 'the requested time slot is already exist');
        $repository->removeIntersectDuration($user, $bookTimes->getDate(), $bookTimes->getToDate());
        /**
         * @todo: Add Other Interviewer Specific business rules
         */

        //according to grasp creator pattern: https://en.wikipedia.org/wiki/GRASP_(object-oriented_design)#Creator
        $timeSheet = new TimeSheetEntity();
        $timeSheet->setUser($user);
        $timeSheet->setTime($bookTimes);
        $repository->update($timeSheet);
    }
}
