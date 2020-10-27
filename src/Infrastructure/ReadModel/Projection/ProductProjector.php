<?php
declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

use App\Domain\Event\ProductWasCreated;
use App\Infrastructure\ReadModel\MySqlReadModelProductRepository;

class ProductProjector
{
    private MySqlReadModelProductRepository $mySqlProjection;

    public function __construct(MySqlReadModelProductRepository $mySqlProjection)
    {
        $this->mySqlProjection = $mySqlProjection;
    }

    public function whenProductWasCreated(ProductWasCreated $productWasCreated)
    {
        $this->mySqlProjection->create(
            $productWasCreated->getId(),
            $productWasCreated->getName(),
            $productWasCreated->getPrice(),
        );

        // można dodać inną projekcję np. na elastic search
    }
}
