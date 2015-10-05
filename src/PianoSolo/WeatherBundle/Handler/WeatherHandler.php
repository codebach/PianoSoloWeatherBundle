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
	 * Gets the weather list of a city
	 * 
	 * @param mixed (integer|string) $city
	 * @return array of Weathers
	 */
	public function getForecast($city, $days = 3)
	{
		$weathers = $this->weatherService->getForecast($city, $days);
		
		return $weathers;
	}
	
	/**
	 * Gets the weather of a city
	 * 
	 * @param mixed (integer|string) $city
	 * @return array of Weathers 
	 */
	public function getWeather($city)
	{
		$weathers = $this->weatherService->getWeather($city);
		
		return $weathers;
	}
}
