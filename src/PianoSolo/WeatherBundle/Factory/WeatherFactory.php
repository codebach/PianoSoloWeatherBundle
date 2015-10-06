<?php

namespace PianoSolo\WeatherBundle\Factory;

use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;

/**
 * Gets data from Weather Services
 * 
 * @author Ahmet Akbana
 */
class WeatherFactory
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
		return $this->weatherService->getForecastObject($city, $days);
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
		return $this->weatherService->getWeatherObject($city);
	}
}
