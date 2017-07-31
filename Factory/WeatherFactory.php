<?php

namespace PianoSolo\WeatherBundle\Factory;

use PianoSolo\WeatherBundle\Entity\Weather;
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
     * @param ApcCache                $apcCache
     * @param bool                    $cacheIsEnabled
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
     * @param array  $param
     *
     * @return /stdClass
     */
    public function getData($type, array $param = null)
    {
        return $this->weatherService->getData($type, $param);
    }

    /**
     * @param string $type
     * @param mixed  $city
     * @param array  $param
     *
     * @return /stdClass
     */
    public function getCityData($type, $city, array $param = null)
    {
        return $this->weatherService->getCityData($type, $city, $param);
    }

    /**
     * @param mixed $city
     * @param int   $days
     *
     * @return /stdClass
     */
    public function getForecast($city, $days = 3)
    {
        // Checking if cache is enabled
        if ($this->cacheIsEnabled) {
            $cacheID = $city.$days.'fc';

            if (!$weathers = $this->getCache($cacheID)) {
                $weathers = $this->weatherService->getForecast($city, $days);
                $this->saveCache($cacheID, $weathers);
            }

            return $weathers;
        }

        return $this->weatherService->getForecast($city, $days);
    }

    /**
     * @param mixed $city
     * @param int   $days
     *
     * @return Weather[]
     */
    public function getForecastObject($city, $days = 3)
    {
        // Checking if cache is enabled
        if ($this->cacheIsEnabled) {
            $cacheID = $city.$days.'fcO';

            if (!$weathers = $this->getCache($cacheID)) {
                $weathers = $this->weatherService->getForecastObject($city, $days);
                $this->saveCache($cacheID, $weathers);
            }

            return $weathers;
        }

        return $this->weatherService->getForecastObject($city, $days);
    }

    /**
     * @param mixed $city
     *
     * @return /stdClass
     */
    public function getWeather($city)
    {
        // Check if cache is enabled
        if ($this->cacheIsEnabled) {
            $cacheID = $city.'w';

            if (!$weather = $this->getCache($cacheID)) {
                $weather = $this->weatherService->getWeather($city);
                $this->saveCache($cacheID, $weather);
            }

            return $weather;
        }

        return $this->weatherService->getWeather($city);
    }

    /**
     * @param mixed $city
     *
     * @return Weather[]
     */
    public function getWeatherObject($city)
    {
        // Checking if cache is enabled
        if ($this->cacheIsEnabled) {
            $cacheID = $city.'wO';

            if (!$weathers = $this->getCache($cacheID)) {
                $weathers = $this->weatherService->getWeatherObject($city);
                $this->saveCache($cacheID, $weathers);
            }

            return $weathers;
        }

        return $this->weatherService->getWeatherObject($city);
    }

    /**
     * @param mixed $cacheID
     *
     * @return mixed
     */
    private function getCache($cacheID)
    {
        if ($this->appCache->contains($cacheID)) {
            return unserialize($this->appCache->fetch($cacheID));
        }

        return false;
    }

    /**
     * @param mixed $cacheID
     * @param mixed $weathers
     */
    private function saveCache($cacheID, $weathers)
    {
        $this->appCache->save($cacheID, serialize($weathers), 3600);
    }
}
