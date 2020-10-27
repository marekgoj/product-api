<?php

declare(strict_types=1);

namespace App\Domain\Port;

use App\Domain\Event\EventInterface;

interface EventBusGatewayInterface
{
    public function publish(EventInterface $event): void;
}
