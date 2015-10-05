<?php

namespace PianoSolo\WeatherBundle\Service\Weather;

interface WeatherServiceInterface
{
	/**
	 * @param mixed (int|string) $city
	 * @return array of Weathers
	 */
	public function getWeather($city);
	
	/**
	 * @param mixed (int|string)$city
	 * @param int $days
	 * @return array of Weathers
	 */
	public function getForecast($city, $days);
}
