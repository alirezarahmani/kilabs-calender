<?php

namespace App\Infrastructure\Validator;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class BookTimeApiValidator implements ValidatorInterface
{
    public function validate(array $inputs)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'hour' => new Assert\Collection([
                new Assert\Time(),
                new Assert\NotBlank(),
            ]),
            'date' => new Assert\Date(),
            'toHour' => new Assert\Time(),
            'toDate' => new Assert\Date(),
            //@todo: must remove these
            'id' => new Assert\NotBlank(),
            'userType' => new Assert\NotBlank()
        ]);

        $violations = $validator->validate($inputs, $constraint);
        if (0 !== count($violations)) {
            $errors = '';
            foreach ($violations as $violation) {
                $errors .= $violation->getMessage().'<br>';
            }
            throw new InvalidArgumentException($errors);
        }
    }
}