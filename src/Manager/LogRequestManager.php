<?php

namespace App\Manager;

use App\Entity\LogRequest;
use App\Repository\LogRequestRepository;

class LogRequestManager
{
    public function __construct(
        private readonly LogRequestRepository $logRequestRepository
    ) {
    }

    public function getOrCreateLogRequest(string $key): LogRequest
    {
        $logRequest = $this->logRequestRepository->findOneByKey($key);

        if (!$logRequest) {
            $logRequest = new LogRequest();
            $logRequest->setKey($key);
            $this->logRequestRepository->save($logRequest, true);
        }

        return $logRequest;
    }

    public function increaseCount(LogRequest $logRequest): void
    {
        $logRequest->setCount($logRequest->getCount() + 1);
        $this->logRequestRepository->save($logRequest, true);
    }
}
