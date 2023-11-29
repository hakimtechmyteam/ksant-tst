<?php

namespace App\Controller;

use App\Dto\CustomersOutput;
use App\Event\EndpointRequestCountEvent;
use App\Manager\LogRequestManager;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsController]
class GetCustomersController extends AbstractController
{
    public function __invoke(
        Request $request,
        CustomerRepository $customerRepository,
        EventDispatcherInterface $eventDispatcher,
        LogRequestManager $logRequestManager,
    ) {
        $routeName = $request->attributes->get('_route');
        $httpMethod = $request->getMethod();

        $eventDispatcher->dispatch(new EndpointRequestCountEvent($routeName, $httpMethod));
        $logRequest = $logRequestManager->getOrCreateLogRequest($routeName, $httpMethod);

        return new CustomersOutput($logRequest->getCount(), $customerRepository->all());
    }
}
