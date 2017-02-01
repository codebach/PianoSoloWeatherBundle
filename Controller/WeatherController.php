<?php

namespace PianoSolo\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PianoSolo\WeatherBundle\Http\WeatherCsvResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherController extends Controller
{
    /**
     * Downloads Weather List of City as CSV
     *
     * @param mixed (int|string) $city
     * @param integer $days
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function generateCsvAction($city, $days)
    {
        if ($this->getParameter('pianosolo.weather.options.download_csv') === TRUE) {
            $weatherHandler = $this->get('pianosolo.weather');

            $weathers = $weatherHandler->getForecastObject($city, $days);

            if (!empty($weathers)) {
                // Creating CSV Response
                $csvResponse = new WeatherCsvResponse($weathers, $city);

                return $csvResponse->createCsvResponse();
            }

            throw $this->createNotFoundException('City Not Found!');
        }

        throw $this->createNotFoundException('Page Not Found!');
    }
}
