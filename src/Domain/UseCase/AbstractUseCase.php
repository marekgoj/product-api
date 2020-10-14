<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Exception\ValidationViolationException;
use App\Domain\Port\ValidatorGatewayInterface;

abstract class AbstractUseCase
{
    private ValidatorGatewayInterface $validator;
    protected ValidationViolationException $exception;

    public function __construct(ValidatorGatewayInterface $validator)
    {
        $this->validator = $validator;
        $this->exception = new ValidationViolationException();
    }

    protected function validate($object): void
    {
        $this->validator->validate($object, $this->exception);
        $this->resolveException();
    }

    protected function resolveException(): void
    {
        if ($this->exception->hasViolations()) {
            throw $this->exception;
        }
    }
}
