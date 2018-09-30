<?php
declare(strict_types=1);
namespace App\Domain\Model;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Validator\ValidatorInterface;
use Assert\Assertion;
use Doctrine\ORM\EntityManagerInterface;

class FreeTimeFactory
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
     * @param FreeTimeDuration    $bookingTimeFormat
     */
    public function set(
        array $inputs,
        ValidatorInterface $applyTimeApiValidator,
        RepositoryInterface $repository,
        FreeTimeFormatInterface $bookingTimeFormat
    ) {
        $applyTimeApiValidator->validate($inputs);

        //according to grasp creator pattern: https://en.wikipedia.org/wiki/GRASP_(object-oriented_design)#Creator
        $timeDuration = new FreeTimeDuration(
            $bookingTimeFormat,
            $inputs['date'],
            $inputs['hour'],
            $inputs['toDate'] ?? null,
            $inputs['toHour'] ?? null
        );
        /**
         * @TODO: fix this
         * $inputs['userType'] MUST GET FROM SESSION (LOGGED USER)
         * $inputs['userId'] MUST GET FROM SESSION (LOGGED USER)
         * BECAUSE WE DO NOT HAVE AUTHENTICATION WE GET THEM FROM INPUTS
         */
        if ($inputs['userType'] == self::INTERVIEWER) {
            /** @var EmployerEntity $employer */
            $employer = $this->entityManager->getRepository(EmployerEntity::class)->find($inputs['id']);
            Assertion::notEmpty($employer, 'sorry, the employer with id:' . $inputs['id'] . ' is not found');
            (new InterviewerFreeTimes())->apply($employer, $timeDuration, $repository);
        } elseif ($inputs['userType'] == self::CANDIDATE) {
            /** @var UserEntity $user */
            $user = $this->entityManager->getRepository(UserEntity::class)->find($inputs['id']);
            Assertion::notEmpty($user, 'sorry, the user with id:' . $inputs['id'] . ' is not found');
            (new CandidateFreeTimes())->apply($user, $timeDuration, $repository);
        }
    }
}
