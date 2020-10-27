<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Port\CreateProductInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProduct implements CreateProductInterface
{
    protected string $id;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 191)
     */
    protected $name;

    /**
     * @Assert\Type("int")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    protected $price;

    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public static function createFromRequest(Request $request): self
    {
        return new self(
            Uuid::uuid4()->toString(),
            $request->request->get('name'),
            $request->request->get('price'),
        );
    }
}
