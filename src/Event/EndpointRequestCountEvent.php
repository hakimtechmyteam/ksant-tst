<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class EndpointRequestCountEvent extends Event
{
    public function __construct(
        protected string $key,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
