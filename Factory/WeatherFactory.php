<?php

namespace PianoSolo\WeatherBundle\Factory;

use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * @param WeatherServiceInterface $weatherService
	 * @param ContainerInterface $container
	 */
	public function __construct(WeatherServiceInterface $weatherService, ContainerInterface $container)
	{
		$this->weatherService = $weatherService;
		$this->container = $container;
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
		// Cheking if cache is enabled
		if($this->container->getParameter('pianosolo.weather.options.cache') === TRUE){
			
			$cacheID = $city.$days.'fc';
			
			if(!$weathers = $this->getCache($cacheID)){
				$weathers = $this->weatherService->getForecast($city, $days);
				$this->saveCache($cacheID, $weathers);
			}
		}else{
			$weathers = $this->weatherService->getForecast($city, $days);
		}
		
		return $weathers;
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
		// Cheking if cache is enabled
		if($this->container->getParameter('pianosolo.weather.options.cache') === TRUE){
			
			$cacheID = $city.$days.'fcO';
			
			if(!$weathers = $this->getCache($cacheID)){
				$weathers = $this->weatherService->getForecastObject($city, $days);
				$this->saveCache($cacheID, $weathers);
			}
		}else{
			$weathers = $this->weatherService->getForecastObject($city, $days);
		}
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
		// Cheking if cache is enabled
		if($this->container->getParameter('pianosolo.weather.options.cache') === TRUE){
			
			$cacheID = $city.'w';
			
			if(!$weather = $this->getCache($cacheID)){
				$weather = $this->weatherService->getWeather($city);
				$this->saveCache($cacheID, $weather);
			}
		}else{
			$weather = $this->weatherService->getWeather($city);
		}
		return $weather;
	}
	
	/**
	 * Gets weather as Weather object
	 * 
	 * @param mixed (integer|string) $city
	 * @return array of Weather Object
	 */
	public function getWeatherObject($city)
	{
		// Cheking if cache is enabled
		if($this->container->getParameter('pianosolo.weather.options.cache') === TRUE){
			
			$cacheID = $city.'wO';
			
			if(!$weather = $this->getCache($cacheID)){
				$weather = $this->weatherService->getWeatherObject($city);
				$this->saveCache($cacheID, $weather);
			}
		}else{
			$weather = $this->weatherService->getWeatherObject($city);
		}
		return $weather;
	}
	
	/**
	 * Gets cache by cacheID
	 * 
	 * @param mixed (integer|string) $cacheID
	 * @return mixed (Weather|boolean false)
	 */
	private function getCache($cacheID)
	{
		$cache = $this->container->get('pianosolo.weather.cache');
		if ($cache->contains($cacheID)) {
			return unserialize($cache->fetch($cacheID));
		}else{
			return false;
		}
	}
	
	/**
	 * Save cache by cacheID
	 * 
	 * @param mixed (integer|string) $cacheID
	 * @param array $weathers
	 */
	private function saveCache($cacheID, $weather)
	{
		$cache = $this->container->get('pianosolo.weather.cache');
		$cache->save($cacheID, serialize($weather), 3600);
	}
}
