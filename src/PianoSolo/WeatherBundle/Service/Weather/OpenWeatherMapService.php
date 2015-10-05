<?php

namespace PianoSolo\WeatherBundle\Service\Weather;

use PianoSolo\WeatherBundle\Entity\Weather;
use PianoSolo\WeatherBundle\Service\HttpClient\HttpClientInterface;

class OpenWeatherMapService implements WeatherServiceInterface
{
	/**
	 * @var string
	 */
	private $apiUrl = 'http://api.openweathermap.org/data/2.5/';
	
	/**
	 * @var HttpClientInterface
	 */
	private $httpClient;
	
	/**
	 * @var array Weather
	 */	
	private $weathers = array();
	
	/**
	 * @param HttpClientInterface $httpClient
	 */
	public function __construct(HttpClientInterface $httpClient)
	{
		$this->httpClient = $httpClient;
	}
	
	/**
	 * Gets data from OpenWeatherMap Api
	 * 
	 * @param string $type
	 * @param Array $param
	 * @return stdClass
	 */
	public function getData($type, Array $param = null)
	{
		$url = $this->apiUrl.$type.'?';
		
		$urlKeys = array();
		foreach ($param as $key => $value) {
			$urlKeys[] = $key.'='.rawurlencode($value);
		}
		$url .= implode('&', $urlKeys);
		
		return json_decode($this->httpClient->getResponseBody($url));
		
	}
	
	/**
	 * Gets City data
	 * 
	 * @param string $type
	 * @param mixed (int|string) $city
	 * @param Array $param
	 * @return Array Weathers
	 */
	public function getCityData($type, $city, $param = null)
	{
		if(is_numeric($city)){
			$param['id'] = $city;
		}else{
			$param['q'] = $city;
		}
		
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
	public function getForecast($city, $days='3')
	{
		$results = $this->getCityData('forecast/daily', $city, array('cnt'=>$days));
		
		if($results->cod == '200'){
			$date = date("Y-m-d");
			foreach ($results->list as $list) {
				
				if(count($this->weathers)>0){
					$date = strftime("%Y-%m-%d", strtotime("$date +1 day"));
				}
				
				$newWeather = new Weather();
				$newWeather->setCity($results->city->name);
				$newWeather->setWdate($date);
				$newWeather->setDescription($list->weather[0]->main);
				$cTemp = $list->temp->day-273 ;
				$newWeather->setTemperature(number_format($cTemp,1));
				
				$this->weathers[] = $newWeather;
			}
		}
		
		return $this->weathers;
	}
}