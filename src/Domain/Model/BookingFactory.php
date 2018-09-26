<?php

namespace App\Domain\Model;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class BookingFactory
{
    // @todo: fix this
    const CANDIDATE = 'candidate';
    const INTERVIEWER = 'interviewer';

    const TYPES = [
        self::CANDIDATE,
        self::INTERVIEWER
    ];

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array               $inputs
     * @param ValidatorInterface  $applyTimeApiValidator
     * @param RepositoryInterface $repository
     * @param HourlyTimeSlot $timeSlot
     */
    public function book(array $inputs , ValidatorInterface $applyTimeApiValidator, RepositoryInterface $repository, TimeSlotInterface $timeSlot)
    {
        $applyTimeApiValidator->validate($inputs);
        $timeSlots = $timeSlot->bookTimes($inputs['date'], $inputs['time'], $inputs['toDate'], $inputs['toTime']);
        /**
         * @TODO: fix this
         * $inputs['userType'] MUST GET FROM SESSION (LOGGED USER)
         * $inputs['userId'] MUST GET FROM SESSION (LOGGED USER)
         * BECAUSE WE DO NOT HAVE AUTHENTICATION WE GET THEM FROM INPUTS
         */
        if ($inputs['userType'] == self::INTERVIEWER) {
            /** @var EmployerEntity $employer */
            $employer = $this->entityManager->getRepository(EmployerEntity::class)->find($inputs['id']);
            (new Interviewer())->apply($employer, $timeSlots, $repository);
        } elseif ($inputs['userType'] == self::CANDIDATE) {
            /** @var UserEntity $user */
            $user = $this->entityManager->getRepository(UserEntity::class)->find($inputs['id']);
            (new Candidate())->apply($user, $timeSlots, $repository);
        }
    }
}