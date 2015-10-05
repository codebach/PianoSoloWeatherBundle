<?php

namespace PianoSolo\WeatherBundle\Service\Weather;

use PianoSolo\WeatherBundle\Entity\Weather;
use PianoSolo\WeatherBundle\Service\HttpClient\HttpClientInterface;

class YahooWeatherService implements WeatherServiceInterface
{
	/**
	 * @var HttpClientInterface
	 */
	private $httpClient;
	
	/**
	 * @var array Weathers
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
	 * @{inheritdoc}
	 */
	public function getWeather($city)
	{
		
	}
}
