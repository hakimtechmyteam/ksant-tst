<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\WeatherService;
use Doctrine\ORM\EntityManagerInterface;

class WeatherStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly WeatherService $weatherService,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $weather = $this->weatherService->getCurrentWeatherByCity($uriVariables['city']);

        if ($weather) {
            $this->entityManager->persist($weather);
            $this->entityManager->flush();
        }

        return $weather;
    }
}
