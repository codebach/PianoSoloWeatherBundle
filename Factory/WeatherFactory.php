<?php

namespace PianoSolo\WeatherBundle\Factory;

use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;
use Doctrine\Common\Cache\ApcCache;

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
	 * @var ApcCache
	 */
	private $appCache;

	/**
	 * @var boolean
	 */
	private $cacheIsEnabled;

	/**
	 * @param WeatherServiceInterface $weatherService
	 * @param ApcCache $apcCache
	 * @param string $cacheIsEnabled
	 */
	public function __construct(WeatherServiceInterface $weatherService, ApcCache $apcCache, $cacheIsEnabled)
	{
		$this->weatherService = $weatherService;
		$this->appCache = $apcCache;
		$this->cacheIsEnabled = $cacheIsEnabled;
	}

	/**
	 * Gets data from api
	 *
	 * @param string $type
	 * @param array $param
	 * @return /stdClass
	 */
	public function getData($type, Array $param = null)
	{
		return $this->weatherService->getData($type, $param);
	}

	/**
	 * Gets data by city name or id from api
	 *
	 * @param string $type
	 * @param mixed (integer|string) $city
	 * @param array $param
	 * @return /stdClass
	 */
	public function getCityData($type, $city, Array $param = null)
	{
		return $this->weatherService->getCityData($type, $city, $param);
	}

	/**
	 * Gets the forecast as response
	 *
	 * @param mixed (integer|string) $city
	 * @param int $days
	 * @return /stdClass
	 */
	public function getForecast($city, $days = 3)
	{
		// Cheking if cache is enabled
		if($this->cacheIsEnabled){

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
	 * @return array Weather Object
	 */
	public function getForecastObject($city, $days = 3)
	{
		// Cheking if cache is enabled
		if($this->cacheIsEnabled){

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
	 * @return /stdClass
	 */
	public function getWeather($city)
	{
		// Cheking if cache is enabled
		if($this->cacheIsEnabled){

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
		if($this->cacheIsEnabled){

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
		if ($this->appCache->contains($cacheID)) {
			return unserialize($this->appCache->fetch($cacheID));
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
		$this->appCache->save($cacheID, serialize($weather), 3600);
	}
}
