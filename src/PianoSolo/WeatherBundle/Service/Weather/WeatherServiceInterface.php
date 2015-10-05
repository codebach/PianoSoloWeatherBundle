<?php

namespace PianoSolo\WeatherBundle\Service\Weather;

/**
 * Gets weather and forecast from api
 * 
 * @author Ahmet Akbana
 */
interface WeatherServiceInterface
{
	/**
	 * @param mixed (integer|string) $city
	 * @return array of Weathers
	 */
	public function getWeather($city);
	
	/**
	 * @param mixed (integer|string)$city
	 * @param int $days
	 * @return array of Weathers
	 */
	public function getForecast($city, $days);
}
