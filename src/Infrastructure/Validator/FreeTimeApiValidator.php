<?php
declare(strict_types=1);
namespace App\Infrastructure\Validator;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;

class FreeTimeApiValidator implements ValidatorInterface
{
    public function validate(array $inputs)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'hour' => [
                new Assert\Time(),
                new Assert\NotBlank()
            ],
            'date' => new Assert\Date(),
            'toHour' => new Assert\Optional([
                new Assert\Time(),
                new Assert\Callback(
                    function ($object, ExecutionContextInterface $context, $payload) use ($inputs) {
                        if (!isset($inputs['toDate']) && $object < $inputs['hour']) {
                            $context->buildViolation('please make sure toHour is greater than hour')
                                ->atPath('toHour')
                                ->addViolation();
                        }
                    }
                )
            ]),
            'toDate' => new Assert\Optional([
                new Assert\Date(),
                new Assert\GreaterThan($inputs['date'] ?? ''),
                new Assert\NotEqualTo($inputs['date'] ?? ''),
                new Assert\Callback(
                    function ($object, ExecutionContextInterface $context, $payload) use ($inputs) {
                        if (!isset($inputs['toHour'])) {
                            $context->buildViolation('please make sure toHour is set')
                                ->atPath('toHour')
                                ->addViolation();
                        }
                    }
                )]),
            //@todo: must remove these
            'id' => new Assert\NotBlank(),
            'userType' => new Assert\NotBlank()
        ]);

        $violations = $validator->validate($inputs, $constraint);
        if (0 !== count($violations)) {
            $errors = [];
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errors[] = implode('', $violation->getParameters()) . $violation->getMessage();
            }
            throw new InvalidArgumentException(json_encode($errors));
        }
    }
}
