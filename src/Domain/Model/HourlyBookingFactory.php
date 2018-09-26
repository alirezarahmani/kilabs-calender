<?php

namespace App\Domain\Model;

use App\Domain\Entity\TimeSheet;
use App\Domain\Repository\RepositoryInterface;
use App\Domain\Entity\User;
use App\Infrastructure\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Assert\Assertion;

class HourlyBookingFactory
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function book(array $inputs , RepositoryInterface $userRepository, ValidatorInterface $applyTimeApiValidator)
    {
        $applyTimeApiValidator->validate($inputs);
        $user = $userRepository->find($inputs['userId']);

        Assertion::inArray($user->getType(), User::TYPES, 'wrong types found');

        $repository = $this->entityManager->getRepository(TimeSheet::class);
        $bookingRule = HourlyBooking::newInstance($inputs);

        if ($user->getType() == User::INTERVIEWER) {
            (new Interviewer())->apply($inputs, $bookingRule, $repository);
        } elseif ($user->getType() == User::CANDIDATE) {
            (new Candidate())->apply($inputs, $bookingRule, $repository);
        }
    }
}