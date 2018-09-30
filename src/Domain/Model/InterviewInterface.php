<?php
declare(strict_types=1);
namespace App\Domain\Model;

use App\Domain\Entity\EntityInterface;
use App\Domain\Repository\RepositoryInterface;

interface InterviewInterface
{
    public function apply(EntityInterface $employer, FreeTimesInterface $bookTimes, RepositoryInterface $repository);
}
