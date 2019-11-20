<?php

namespace App\Tests\Service;

use App\Service\WeatherForecast;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherForecastTest extends TestCase
{
    protected const TEST_PATH = './Data/';

    public function testGetForecast(): void
    {
        $testOkResponseContent = file_get_contents(self::TEST_PATH . 'weather_response_ok.txt');
        $testOkResponse = new MockResponse($testOkResponseContent);
        $testFailResponseContent = file_get_contents(self::TEST_PATH . 'weather_response_fail.txt');
        $testFailResponse = new MockResponse($testFailResponseContent);

        $httpClient = new MockHttpClient([$testOkResponse, $testFailResponse]);

        $weatherForecast = new WeatherForecast($httpClient, 'test_key');
        $data = $weatherForecast->getForecast('Lviv');

        $fields = ['temperature', 'weather_icons', 'weather_descriptions', 'wind_speed', 'wind_degree', 'wind_dir',
            'pressure', 'precip', 'humidity', 'cloudcover', 'feelslike', 'uv_index', 'location'];
        foreach ($fields as $field) {
            $this->assertArrayHasKey($field, $data);
        }

        $this->expectException(HttpException::class);
        $weatherForecast->getForecast('Error_city_name');
    }
}