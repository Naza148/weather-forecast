<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherForecast implements WeatherForecastInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string Access key from weatherstack.com
     */
    protected $apiKey;

    /**
     * @var string API host
     */
    protected $apiUrl = 'http://api.weatherstack.com/';

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $city
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getForecast(string $city): array
    {
        $data = $this->request('current', ['query' => $city]);

        $current = $data['current'];

        return [
            'location' => [
                'name' => $data['location']['name'],
                'country' => $data['location']['country'],
            ],
            'temperature' => $current['temperature'],
            'weather_icons' => $current['weather_icons'],
            'weather_descriptions' => $current['weather_descriptions'],
            'wind_speed' => $current['wind_speed'],
            'wind_degree' => $current['wind_degree'],
            'wind_dir' => $current['wind_dir'],
            'pressure' => $current['pressure'],
            'precip' => $current['precip'],
            'humidity' => $current['humidity'],
            'cloudcover' => $current['cloudcover'],
            'feelslike' => $current['feelslike'],
            'uv_index' => $current['uv_index'],
        ];
    }

    /**
     * @param string $name
     * @param array $params
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function request(string $name, array $params): array
    {
        $params['access_key'] = $this->apiKey;
        $response = $this->httpClient->request('GET', $this->apiUrl . $name, [
            'query' => $params,
        ]);
        $res = json_decode($response->getContent(), true);

        if (isset($res['success']) && $res['success'] === false) {
            if (isset($res['error']['info'])) {
                $message = $res['error']['info'];
            } else {
                $message = 'HTTP error';
            }

            throw new HttpException($response->getStatusCode(), $message);
        }

        return $res;
    }
}