<?php

namespace PianoSolo\WeatherBundle\Service\Weather;

use PianoSolo\WeatherBundle\Entity\Weather;
use PianoSolo\WeatherBundle\Service\HttpClient\HttpClientInterface;

/**
 * Gets weather and forecast from OpenWeatherMap Api
 * 
 * @author Ahmet Akbana
 */
class OpenWeatherMapService implements WeatherServiceInterface
{
    /**
     * @var string
     */
    private $apiUrl = 'http://api.openweathermap.org/data/2.5/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     * @param string              $apiKey
     */
    public function __construct(HttpClientInterface $httpClient, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    /**
     * @{inheritdoc}
     */
    public function getData($type, $param = null)
    {
        if (!isset($param['APPID'])) {
            $param['APPID'] = $this->apiKey;
        }

        $url = $this->apiUrl.$type.'?';

        $urlKeys = array();
        foreach ($param as $key => $value) {
            $urlKeys[] = $key.'='.rawurlencode($value);
        }
        $url .= implode('&', $urlKeys);

        return json_decode($this->httpClient->getResponseBody($url));
    }

    /**
     * @{inheritdoc}
     */
    public function getCityData($type, $city, $param = null)
    {
        if (is_numeric($city)) {
            $param['id'] = $city;

            return $this->getData($type, $param);
        }

        $param['q'] = $city;

        return $this->getData($type, $param);
    }

    /**
     * @{inheritdoc}
     */
    public function getWeather($city)
    {
        return $this->getCityData('weather', $city);
    }

    /**
     * @{inheritdoc}
     */
    public function getWeatherObject($city)
    {
        $results = $this->getWeather($city);

        $weathers = array();

        if ($results->cod === 200) {
            $date = date("d-m-Y");

            $newWeather = new Weather();
            $newWeather->setCity($results->name);
            $newWeather->setWdate($date);
            $newWeather->setDescription($results->weather[0]->main);
            $cTemp = $results->main->temp-273; //Celcius
            $newWeather->setTemperature(number_format($cTemp,1));

            $weathers[] = $newWeather;
        }

        return $weathers;
    }

    /**
     * @{inheritdoc}
     */
    public function getForecast($city, $days = 3)
    {
        return $this->getCityData('forecast/daily', $city, array('cnt'=>$days));
    }

    /**
     * @{inheritdoc}
     */
    public function getForecastObject($city, $days = 3)
    {
        $results = $this->getForecast($city, $days);

        $weathers = array();

        if ($results->cod === '200') {
            $date = date("d-m-Y");

            foreach ($results->list as $list) {
                if(count($weathers)>0){
                    $date = strftime("%d-%m-%Y", strtotime("$date +1 day"));
                }

                $newWeather = new Weather();
                $newWeather->setCity($results->city->name);
                $newWeather->setWdate($date);
                $newWeather->setDescription($list->weather[0]->main);
                $cTemp = $list->temp->day-273; //Celcius
                $newWeather->setTemperature(number_format($cTemp,1));

                $weathers[] = $newWeather;
            }
        }

        return $weathers;
    }
}
