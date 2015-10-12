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
	 * Gets Weather
	 * 
	 * @param mixed (integer|string) $city
	 * @return stdClass
	 */
	public function getWeather($city);
	
	/**
	 * Gets Weather as Object
	 * 
	 * @param mixed (integer|string) $city
	 * @return Array Weather Object
	 */
	public function getWeatherObject($city);
	
	/**
	 * Gets Forecast
	 * 
	 * @param mixed (integer|string)$city
	 * @param int $days
	 * @return stdClass
	 */
	public function getForecast($city, $days);
	
	/**
	 * Gets Forecast as Weather Object
	 * 
	 * @param mixed (integer|string) $city
	 * @param int $days
	 * @return Array Weather Object
	 */
	public function getForecastObject($city, $days);
}
