<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Product;
use App\Domain\Port\CreateProductInterface;
use App\Domain\Port\ProductGatewayInterface;
use App\Domain\Port\ValidatorGatewayInterface;

class CreateProductUseCase extends AbstractUseCase
{
    protected ProductGatewayInterface $productGateway;

    public function __construct(
        ProductGatewayInterface $productGateway,
        ValidatorGatewayInterface $validator
    ) {
        $this->productGateway = $productGateway;
        parent::__construct($validator);
    }

    public function create(CreateProductInterface $createProduct): Product
    {
        $this->validate($createProduct);
        $product = new Product($createProduct->getName(), $createProduct->getPrice());
        $this->productGateway->save($product);

        return $product;
    }

    protected function validate($createProduct): void
    {
        parent::validate($createProduct);

        if ($this->productGateway->findByName($createProduct->getName())) {
            $this->exception->addViolation('name', 'Name is not unique.');
        }

        $this->resolveException();
    }
}
