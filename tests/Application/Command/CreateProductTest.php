<?php

declare(strict_types=1);

namespace App\Tests\Application\Command;

use App\Application\Command\CreateProduct;
use App\Domain\Exception\ValidationViolationException;
use App\Infrastructure\Validator\ValidatorGatewayAdapter;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateProductTest extends KernelTestCase
{
    private ValidatorGatewayAdapter $validator;

    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
        $this->validator = self::$container->get(ValidatorGatewayAdapter::class);
    }

    /**
     * @dataProvider validationCases
     *
     * @param string $uuid
     * @param $name
     * @param $price
     */
    public function testValidation(string $uuid, $name, $price): void
    {
        $exception = new ValidationViolationException();
        $createProduct = new CreateProduct(Uuid::uuid4()->toString(), str_repeat('X', 1000), 10);
        $this->validator->validate($createProduct, $exception);

        $this->assertTrue($exception->hasViolations());
    }

    public function validationCases(): array
    {
        $uuid = Uuid::uuid4()->toString();
        return [
            [$uuid, str_repeat('X', 1000), 10], //name too long
            [$uuid, 'correct_name', -10], // negative price
            [$uuid, [], 10], // name as array
            [$uuid, '' , 10], // empty name
            [$uuid, 'correct_name' , ''], // empty price
        ];
    }
}
