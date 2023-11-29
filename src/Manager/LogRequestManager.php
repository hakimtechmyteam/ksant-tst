<?php

namespace App\Manager;

use App\Entity\LogRequest;
use App\Repository\LogRequestRepository;
use Psr\Log\LoggerInterface;

class LogRequestManager
{
    public function __construct(
        private readonly LogRequestRepository $logRequestRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    public function getOrCreateLogRequest(string $endpointName, string $httpMethod): LogRequest
    {
        $logRequests = $this->logRequestRepository->findBy([
            'endpoint' => $endpointName,
            'httpMethod' => $httpMethod,
        ]);
        $countLogRequest = count($logRequests);
        if ($countLogRequest > 1) {
            $this->logger->warning(sprintf(
                '[Create or update log request] More than one insert log for endpoint [%s] %s found',
                $httpMethod,
                $endpointName
            ));

            return $this->unionRequests($endpointName, $httpMethod);
        }

        if (0 === $countLogRequest) {
            $logRequest = new LogRequest();
            $logRequest->setEndpoint($endpointName);
            $logRequest->setHttpMethod($httpMethod);
            $this->logRequestRepository->save($logRequest, true);
        }

        return $logRequests[0];
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
