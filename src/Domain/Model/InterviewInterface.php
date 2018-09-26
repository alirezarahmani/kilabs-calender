<?php

namespace App\Domain\Model;

use App\Domain\Entity\EntityInterface;
use App\Domain\Repository\RepositoryInterface;

interface InterviewInterface
{
    public function apply(EntityInterface $employer, TimeSlotInterface $timeSlot, RepositoryInterface $repository);
}