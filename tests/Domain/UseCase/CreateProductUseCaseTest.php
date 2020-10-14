<?php

namespace App\Tests\Domain\UseCase;

use App\Application\Adapter\CreateProduct;
use App\Domain\Entity\Product;
use App\Domain\Exception\ValidationViolationException;
use App\Domain\Port\ProductGatewayInterface;
use App\Domain\Port\ValidatorGatewayInterface;
use App\Domain\UseCase\CreateProductUseCase;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    public function testCreate_NewProduct_Created()
    {
        $createProductUseCase = new CreateProductUseCase(
            $this->getProductGatewayMock(),
            $this->getValidatorGatewayMock()
        );

        $product = $createProductUseCase->create($this->getInputMock('correct name', 100));

        $this->assertEquals('correct name', $product->getName());
        $this->assertEquals(100, $product->getPrice());
    }

    public function testCreate_NameTaken_ValidationExceptionThrown()
    {
        $this->expectException(ValidationViolationException::class);
        $createProductUseCase = new CreateProductUseCase(
            $this->getProductGatewayMock($this->createMock(Product::class)),
            $this->getValidatorGatewayMock()
        );
        $createProductUseCase->create($this->getInputMock('nameTaken', 100));
    }

    private function getProductGatewayMock(?Product $product = null)
    {
        $mock = $this->createMock(ProductGatewayInterface::class);
        if ($product) {
            $mock->expects($this->any())->method('findByName')->willReturn($product);
        }

        return $mock;
    }

    private function getValidatorGatewayMock()
    {
        return $this->createMock(ValidatorGatewayInterface::class);
    }

    private function getInputMock(?string $name, ?int $price)
    {
        $mock = $this->createMock(CreateProduct::class);
        $mock->expects($this->any())->method('getName')->willReturn($name);
        $mock->expects($this->any())->method('getPrice')->willReturn($price);

        return $mock;
    }
}
