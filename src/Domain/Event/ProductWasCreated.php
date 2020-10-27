<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class ProductWasCreated implements EventInterface
{
    private string $id;
    private string $name;
    private int $price;

    public function __construct(string $id, string $name, int $price)
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
}
