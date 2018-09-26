<?php

namespace App\Domain\Model;

use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Validator\ValidatorInterface;

class Interviewer implements InterviewInterface
{
    public function apply(array $inputs, RulesInterface $rule, RepositoryInterface $repository)
    {
        // TODO: Implement apply() method.
    }
}