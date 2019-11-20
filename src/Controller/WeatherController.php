<?php

namespace App\Controller;

use App\Service\WeatherForecast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response('It\'s a Test Weather API');
    }

    /**
     * @Route("/forecast", methods={"GET"})
     *
     * @param Request $request
     * @param WeatherForecast $weatherForecast
     * @return Response
     */
    public function forecast(Request $request, WeatherForecast $weatherForecast): Response
    {
        $city = $request->query->get('city');
        if ($city === null || !$city) {
            return $this->json([
                'error' => 'Parameter \'city\' is required',
            ], 400);
        }

        $res = $weatherForecast->getForecast($city);

        return $this->json($res);
    }
}