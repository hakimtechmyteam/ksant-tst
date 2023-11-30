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
        $page = $request->get('page');
        $key = 'customers';

        $eventDispatcher->dispatch(new EndpointRequestCountEvent($key));
        $logRequest = $logRequestManager->getOrCreateLogRequest($key);

        return new CustomersOutput($logRequest->getCount(), $customerRepository->all($page));
    }
}
