<?php

namespace App\EventSubscriber;

use App\Event\EndpointRequestCountEvent;
use App\Manager\LogRequestManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EndointRequest implements EventSubscriberInterface
{
    public function __construct(
        private readonly LogRequestManager $logRequestManager,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EndpointRequestCountEvent::class => 'countRequest',
        ];
    }

    public function countRequest(EndpointRequestCountEvent $endpointRequestCountEvent): void
    {
        $key = $endpointRequestCountEvent->getKey();

        $logRequest = $this->logRequestManager->getOrCreateLogRequest($key);
        $this->logRequestManager->increaseCount($logRequest);
    }
}
