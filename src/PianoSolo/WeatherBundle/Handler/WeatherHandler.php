<?php

namespace PianoSolo\WeatherBundle\Handler;

use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;

/**
 * Gets data from Weather Services
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
	 * Gets the weathers of city
	 * 
	 * @param string $city
	 * @return array of Weathers
	 */
	public function getForecast($city)
	{
		$weathers = $this->weatherService->getForecast($city);
		
		return $weathers;
	}
}
