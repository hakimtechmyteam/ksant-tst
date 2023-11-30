<?php

namespace App\Command;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:display:customers', description: 'Display all customers information ')]
class CustomersCommand extends Command
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly NormalizerInterface $normalizer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $customers = $this->customerRepository->all();
        $customersCount = count($customers);
        if (0 === $customersCount) {
            $io->warning('No customer found');
        } else {
            $io->title(sprintf('Display %d Customer(s)', $customersCount));

            if ($customers) {
                $io->table(
                    $this->displayCustomerHeader($customers[0]),
                    $this->displayCustomers($customers)
                );
            }
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('Display all customers information and increase request count')
        ;
    }

    private function displayCustomers(array $customers): array
    {
        return $this->normalizer->normalize($customers, context: $this->normalizerContext());
    }

    private function displayCustomerHeader(Customer $customer): array
    {
        return array_keys($this->normalizer->normalize($customer, context: $this->normalizerContext()));
    }

    private function normalizerContext(): array
    {
        return (new ObjectNormalizerContextBuilder())
            ->withGroups('customer:read')
            ->toArray();
    }
}
