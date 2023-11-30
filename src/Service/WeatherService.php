<?php

namespace App\Service;

use App\Entity\Weather;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private const WEATHER_API_HOST = 'https://api.weatherapi.com/v1';

    public function __construct(
        private readonly string $weatherApiKey,
        private readonly HttpClientInterface $client
    ) {
    }

    public function getCurrentWeatherByCity(string $city): ?Weather
    {
        $uri = sprintf('/current.json?q=%s&key=%s', $city, $this->weatherApiKey);
        $response = $this->client->request(
            'GET',
            self::WEATHER_API_HOST.$uri
        );
        if (200 === $response->getStatusCode()) {
            $weatherInfo = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $weather = new Weather();
            $weather->setCity($weatherInfo['location']['name'])
                ->setTemperature($weatherInfo['current']['temp_c']);
            $lastUpdate = new \DateTime($weatherInfo['current']['last_updated']);
            $weather->setLastUpdate($lastUpdate);

            return $weather;
        }

        return null;
    }
}
