<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testForecast(): void
    {
        $client = self::createClient();
        $client->request('GET', '/forecast', ['city' => 'Lviv']);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}