<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use App\Domain\Exception\ValidationViolationException;
use App\Domain\Port\ValidatorGatewayInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorGatewayAdapter implements ValidatorGatewayInterface
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($value, ValidationViolationException $exception): void
    {
        $violations = $this->validator->validate($value);
        foreach ($violations as $violation) {
            $exception->addViolation($violation->getPropertyPath(), $violation->getMessage());
        }
    }
}
