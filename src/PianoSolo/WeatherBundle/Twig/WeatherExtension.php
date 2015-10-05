<?php

namespace PianoSolo\WeatherBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use PianoSolo\WeatherBundle\Service\Weather\WeatherServiceInterface;

/**
 * Twig extension for rendering weather
 * 
 * @author Ahmet Akbana
 */
class WeatherExtension extends \Twig_Extension
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
	
	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('pianosolo_get_weather', array($this, 'weather'), array(
            	'is_safe' => array('html'),
            	'needs_environment' => true
        	)),
			new \Twig_SimpleFunction('pianosolo_get_forecast', array($this, 'forecast'), array(
            	'is_safe' => array('html'),
            	'needs_environment' => true
        	))
		);
	}
	
	/**
	 * Renders weather object of a city
	 * 
	 * @param \Twig_Environment $environment
	 * @param mixed (integer|string) $city
	 * @return template
	 */
	public function weather(\Twig_Environment $environment, $city)
	{
		$weathers = $this->weatherService->getWeather($city);
		
		return $environment->render('PianoSoloWeatherBundle:Weather:weather.html.twig', array(
			'weathers' => $weathers
		));
	}
	
	/**
	 * Renders weather list of a city for days
	 * 
	 * @param \Twig_Environment $environment
	 * @param mixed (integer|string) $city
	 * @param int $days
	 * @return template
	 */
	public function forecast(\Twig_Environment $environment, $city, $days = '3')
	{
		$weathers = $this->weatherService->getForecast($city, $days);
		
		return $environment->render('PianoSoloWeatherBundle:Weather:weather.html.twig', array(
			'city' => $city,
			'weathers' => $weathers
		));
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return 'pianosolo_get';
	}
}
