<?php

declare(strict_types=1);

namespace App\Application\Adapter;

use App\Domain\Port\CreateProductInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProduct implements CreateProductInterface
{
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

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
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
            $request->request->get('name'),
            $request->request->get('price'),
        );
    }
}
