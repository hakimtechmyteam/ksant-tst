<?php

namespace App\Manager;

use App\Entity\LogRequest;
use App\Repository\LogRequestRepository;

class LogRequestManager
{
    public function __construct(
        private readonly LogRequestRepository $logRequestRepository,
    ) {
    }

    public function getOrCreateLogRequest(string $endpointName, string $httpMethod): LogRequest
    {
        try {
            $logRequest = $this->logRequestRepository->findOneBy([
                'endpoint' => $endpointName,
                'httpMethod' => $httpMethod,
            ]);

            if (!$logRequest) {
                $logRequest = new LogRequest();
                $logRequest->setEndpoint($endpointName);
                $logRequest->setHttpMethod($httpMethod);
            }

            return $logRequest;
        } catch (\Exception $exception) {
            // todo log warning more than one log for each endpoint
            return $this->unionRequests($endpointName, $httpMethod);
        }
    }

    public function increaseCount(LogRequest $logRequest): void
    {
        $logRequest->setCount($logRequest->getCount() + 1);
        $this->logRequestRepository->save($logRequest, true);
    }

    private function unionRequests(string $endpointName, string $httpMethod): LogRequest
    {
        $logRequests = $this->logRequestRepository->findBy([
            'endpoint' => $endpointName,
            'httpMethod' => $httpMethod,
        ]);

        $logRequest = new LogRequest();
        $logRequest->setEndpoint($endpointName)
            ->setHttpMethod($httpMethod);
        $count = 0;
        foreach ($logRequests as $logRequestFound) {
            $count += $logRequestFound->getCount();
            $this->logRequestRepository->remove($logRequestFound, true);
        }
        $logRequest->setCount($count);
        $this->logRequestRepository->save($logRequest, true);

        return $logRequest;
    }
}
