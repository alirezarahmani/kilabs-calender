<?php
declare(strict_types=1);
namespace App\Infrastructure\Validator;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class FreeTimeApiValidator implements ValidatorInterface
{
    public function validate(array $inputs)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'hour' => new Assert\Optional([
                new Assert\Time(),
                new Assert\NotBlank()
            ]),
            'date' => new Assert\Date(),
            'toHour' => new Assert\Optional([
                new Assert\DateTime()
            ]),
            'toDate' => new Assert\Optional([
                new Assert\Date()
            ]),
            //@todo: must remove these
            'id' => new Assert\NotBlank(),
            'userType' => new Assert\NotBlank()
        ]);

        $violations = $validator->validate($inputs, $constraint);
        if (0 !== count($violations)) {
            $errors = [];
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errors[] =$violation->getMessage();
            }
            throw new InvalidArgumentException(json_encode($errors));
        }
    }
}
