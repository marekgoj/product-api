<?php

declare(strict_types=1);

namespace App\Domain\Port;

use App\Domain\Exception\ValidationViolationException;

interface ValidatorGatewayInterface
{
    public function validate($value, ValidationViolationException $exception): void;
}
