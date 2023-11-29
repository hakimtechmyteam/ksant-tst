<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class EndpointRequestCountEvent extends Event
{
    public function __construct(
        protected string $endpoint,
        protected string $httpMethod,
    ) {
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }
}
