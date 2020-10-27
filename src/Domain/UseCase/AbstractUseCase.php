<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Event\EventInterface;
use App\Domain\Exception\ValidationViolationException;
use App\Domain\Port\EventBusGatewayInterface;
use App\Domain\Port\ValidatorGatewayInterface;

abstract class AbstractUseCase
{
    protected ValidationViolationException $exception;
    private ValidatorGatewayInterface $validator;
    private EventBusGatewayInterface $eventBus;

    public function __construct(ValidatorGatewayInterface $validator, EventBusGatewayInterface $eventBus)
    {
        $this->validator = $validator;
        $this->exception = new ValidationViolationException();
        $this->eventBus = $eventBus;
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

    protected function publish(EventInterface $event): void
    {
        $this->eventBus->publish($event);
    }
}
