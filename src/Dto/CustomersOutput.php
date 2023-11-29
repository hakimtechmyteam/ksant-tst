<?php

namespace App\Dto;

use ApiPlatform\Doctrine\Orm\Paginator;
use Symfony\Component\Serializer\Annotation\Groups;

class CustomersOutput
{
    public function __construct(int $requestCount, Paginator $customers)
    {
        $this->requestCount = $requestCount;
        $this->customers = $customers;
    }

    #[Groups(['customer:read'])]
    public int $requestCount;

    #[Groups(['customer:read'])]
    public Paginator $customers;
}
