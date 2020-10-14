<?php

declare(strict_types=1);

namespace App\Domain\Port;

use App\Domain\Entity\Product;

interface ProductGatewayInterface
{
    public function save(Product $product): void;

    public function findByName(string $name): ?Product;
}
