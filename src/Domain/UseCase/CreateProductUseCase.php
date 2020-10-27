<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Product;
use App\Domain\Event\ProductWasCreated;
use App\Domain\Port\CreateProductInterface;
use App\Domain\Port\EventBusGatewayInterface;
use App\Domain\Port\ProductGatewayInterface;
use App\Domain\Port\ValidatorGatewayInterface;

class CreateProductUseCase extends AbstractUseCase
{
    protected ProductGatewayInterface $productGateway;

    public function __construct(
        ProductGatewayInterface $productGateway,
        ValidatorGatewayInterface $validator,
        EventBusGatewayInterface $eventBus
    ) {
        $this->productGateway = $productGateway;
        parent::__construct($validator, $eventBus);
    }

    public function create(CreateProductInterface $createProduct): Product
    {
        $this->validate($createProduct);
        $product = new Product($createProduct->getId(), $createProduct->getName(), $createProduct->getPrice());
        $this->productGateway->save($product);

        $this->publish(new ProductWasCreated($product->getId(), $product->getName(), $product->getPrice()));

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
