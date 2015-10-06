<?php

namespace PianoSolo\WeatherBundle\Handler;

use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;

/**
 * Gets data from Weather Services
 * 
 * @author Ahmet Akbana
 */
class WeatherHandler
{
	/**
	 * @var WeatherServiceInterface
	 */
	private $weatherService;
	
	/**
	 * @param WeatherServiceInterface $weatherService
	 */
	public function __construct(WeatherServiceInterface $weatherService)
	{
		$this->weatherService = $weatherService;
	}
	
	/**
	 * Gets the forecast as response
	 * 
	 * @param mixed (integer|string) $city
	 * @param int $days
	 * @return stdClass
	 */
	public function getForecast($city, $days = 3)
	{
		return $this->weatherService->getForecast($city, $days);
	}
	
	/**
	 * Gets forecast as Weather Object
	 * 
	 * @param mixed (integer|string) $city
	 * @param int $days
	 * @return Array Weather Object
	 */
	public function getForecastObject($city, $days = 3)
	{
		$weathers = $this->weatherService->getForecastObject($city, $days);
		
		return $weathers;
	}
	
	/**
	 * Gets the weather as response
	 * 
	 * @param mixed (integer|string) $city
	 * @return stdClass
	 */
	public function getWeather($city)
	{
		return $this->weatherService->getWeather($city);
	}
	
	/**
	 * Gets weather as Weather object
	 * 
	 * @param mixed (integer|string) $city
	 * @return array of Weather Object
	 */
	public function getWeatherObject($city)
	{
		$weathers = $this->weatherService->getWeatherObject($city);
		
		return $weathers;
	}
}
