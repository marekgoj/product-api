<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class ValidationViolationException extends \Exception
{
    protected array $violations = [];

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function addViolation(string $field, $message): void
    {
        $this->violations[$field][] = (string) $message;
    }

    public function hasViolations(): bool
    {
        return count($this->violations) > 0;
    }
}
