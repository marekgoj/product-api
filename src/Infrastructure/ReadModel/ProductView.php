<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

class ProductView
{
    protected string $id;
    protected string $name;
    protected int $price;

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
