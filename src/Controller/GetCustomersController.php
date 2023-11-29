<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCustomersController extends AbstractController
{
    public function __invoke(CustomerRepository $customerRepository)
    {
        return $customerRepository->findAll();
    }
}
