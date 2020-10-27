<?php
declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

interface ProductProjectionInterface
{
    public function create(string $id, string $name, int $price): void;
}
