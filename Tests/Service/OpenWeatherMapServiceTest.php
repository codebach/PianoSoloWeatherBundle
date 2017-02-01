<?php

namespace PianoSolo\WeatherBundle\Tests\Service;

use PianoSolo\WeatherBundle\Entity\Weather;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PianoSolo\WeatherBundle\Service\Weather\OpenWeatherMapService;
use PianoSolo\WeatherBundle\Service\HttpClient\GuzzleHttpClient;

/**
 * Tests OpenWeatherMapService
 * 
 * @author Ahmet Akbana
 */
class OpenWeatherMapServiceTest extends KernelTestCase
{
    /**
     * @var OpenWeatherMapService
     */
    private $service;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $apiKey = static::$kernel->getContainer()->getParameter('pianosolo.weather.api_key');
        $client = new GuzzleHttpClient();
        $this->service = new OpenWeatherMapService($client, $apiKey);
    }

    /**
     * Tests get Weather as stdclass
     */
    public function testGetWeather()
    {
        $response = $this->service->getWeather('istanbul');

        $this->assertTrue($response->cod === 200);
        $this->assertTrue($response->name === 'Istanbul');
        $this->assertEquals(1, count($response->weather));

    }

    /**
     * Tests get Weather as Weather object
     */
    public function testGetWeatherObject()
    {
        $response = $this->service->getWeatherObject('istanbul');

        /** @var Weather $weather */
        foreach ($response as $weather) {
            $this->assertTrue($weather->getCity() == 'Istanbul');
            $this->assertTrue(is_numeric($weather->getTemperature()));
            $this->assertTrue(date('d-m-Y', strtotime($weather->getWdate())) == $weather->getWdate());
            $this->assertTrue($weather->getDescription() !== '');
        }
    }

    /**
     * Tests get Forecast as stdclass
     */
    public function testGetForecast()
    {
        $response = $this->service->getForecast('istanbul', 5);

        $this->assertTrue($response->cod === '200');
        $this->assertEquals(5, count($response->list));
        $this->assertTrue($response->city->name === 'Istanbul');
        $this->assertTrue($response->cnt === 5);
    }

    /**
     * Tests get Forecast as Weather object
     */
    public function testGetForecastObject()
    {
        $response = $this->service->getForecastObject('istanbul', 5);

        $this->assertEquals(5, count($response));

        /** @var Weather $forecast */
        foreach ($response as $forecast) {
            $this->assertTrue($forecast->getCity() == 'Istanbul');
            $this->assertTrue(is_numeric($forecast->getTemperature()));
            $this->assertTrue(date('d-m-Y', strtotime($forecast->getWdate())) == $forecast->getWdate());
            $this->assertTrue($forecast->getDescription() !== '');
        }
    }
}
