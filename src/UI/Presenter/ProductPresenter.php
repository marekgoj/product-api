<?php

declare(strict_types=1);

namespace App\UI\Presenter;

use App\Infrastructure\ReadModel\ProductView;

class ProductPresenter
{
    public string $id;
    public string $name;
    public int $price;

    public function __construct(ProductView $product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
    }

    // Dodałem tą metodę, aby pokazać możliwości presentera, np. można formatować cenę.
    public function getPriceInPLN()
    {
        return sprintf('%01.2f PLN', $this->price / 100);
    }
}
