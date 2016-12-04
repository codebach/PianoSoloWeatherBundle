<?php

namespace PianoSolo\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PianoSolo\WeatherBundle\Http\WeatherCsvResponse;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends Controller
{
    /**
     * Downloads Weather List of City as CSV
     *
     * @param mixed (integer|string) $city
     * @param integer $days
     *
     * @return Response
     */
    public function generateCsvAction($city, $days){

        if($this->getParameter('pianosolo.weather.options.download_csv') === TRUE){

            $weatherHandler = $this->get('pianosolo.weather');
            $weathers = $weatherHandler->getForecastObject($city, $days);

            if(!empty($weathers)){

                // Creating CSV Response
                $csvResponse = new WeatherCsvResponse($weathers, $city);
                return $csvResponse->createCsvResponse();

            }else{
                throw $this->createNotFoundException('City Not Found!');
            }
        }else{
            throw $this->createNotFoundException('Page Not Found!');
        }
    }
}
