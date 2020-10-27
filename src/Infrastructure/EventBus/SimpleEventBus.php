<?php
declare(strict_types=1);

namespace App\Infrastructure\EventBus;

use App\Domain\Event\EventInterface;
use App\Domain\Event\ProductWasCreated;
use App\Domain\Port\EventBusGatewayInterface;
use App\Infrastructure\ReadModel\Projection\ProductProjector;

class SimpleEventBus implements EventBusGatewayInterface
{
    private ProductProjector $productProjector;

    public function __construct(ProductProjector $productProjector)
    {
        $this->productProjector = $productProjector;
    }

    public function publish(EventInterface $event): void
    {
        if ($event instanceof ProductWasCreated) {
            $this->productProjector->whenProductWasCreated($event);
        }
    }
}
