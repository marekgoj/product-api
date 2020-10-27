<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use App\Infrastructure\ReadModel\Exception\NotFoundException;
use App\Infrastructure\ReadModel\Projection\ProductProjectionInterface;
use Doctrine\DBAL\Connection;

class MySqlReadModelProductRepository implements ProductProjectionInterface
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function create(string $id, string $name, int $price): void
    {
        $this->db->insert('read_model_product', [
            'id' => $id,
            'name' => $name,
            'price' => $price
        ]);
    }

    public function findById(string $id): ProductView
    {
        try {
            $statement = $this->db->executeQuery('
                SELECT *
                FROM read_model_product
                WHERE id = :id',
                [
                    'id' => $id
                ]
            );
        } catch (\Exception $e) {
            throw new NotFoundException();
        }

        try {
            $result = $statement->fetchAllAssociative();
        } catch (\Exception $e) {
            throw new NotFoundException();
        }

        if (count($result) === 1) {
            return new ProductView(
                (string)$result[0]['id'],
                (string)$result[0]['name'],
                (int)$result[0]['price'],
            );
        }

        throw new NotFoundException();
    }
}
