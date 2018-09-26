<?php

namespace App\Domain\Model;

use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Validator\ValidatorInterface;

interface InterviewInterface
{
    public function apply(array $inputs, RulesInterface $rule, RepositoryInterface $repository);
}