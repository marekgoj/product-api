<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\Product;
use App\Domain\UseCase\CreateProductUseCase;

class CreateProductHandler
{
    private CreateProductUseCase $createProductUseCase;

    public function __construct(CreateProductUseCase $createProductUseCase)
    {
        $this->createProductUseCase = $createProductUseCase;
    }

    public function handle(CreateProduct $createProductCommand): Product
    {
        return $this->createProductUseCase->create($createProductCommand);
    }
}
