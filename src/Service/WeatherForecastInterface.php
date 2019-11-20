<?php

namespace App\Service;

interface WeatherForecastInterface
{
    public function getForecast(string $city): array;
}