<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Infrastructure\ReadModel\MySqlReadModelProductRepository;
use App\Infrastructure\ReadModel\ProductView;

class FindProductByIdHandler
{
    private MySqlReadModelProductRepository $repository;

    public function __construct(MySqlReadModelProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(FindProductByIdQuery $query): ProductView
    {
        return $this->repository->findById($query->getId());
    }
}
