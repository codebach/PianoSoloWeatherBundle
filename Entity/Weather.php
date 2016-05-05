<?php

namespace PianoSolo\WeatherBundle\Entity;

/**
 * Entity Weather
 * 
 * @author Ahmet Akbana
 */
class Weather
{
    /**
     * @var string
     */
    private $city;

    /**
     * @var \DateTime
     */
    private $wdate;

    /**
     * @var int
     */
    private $temperature;

    /**
     * @var string
     */
    private $description;

    /**
     * Set City
     *
     * @param string $city
     * @return Weather
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get City
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set Weather date
     *
     * @param \DateTime $wdate
     * @return Weather
     */
    public function setWdate($wdate)
    {
        $this->wdate = $wdate;
        return $this;
    }

    /**
     * Get Weather date
     *
     * @return \DateTime $wdate
     */
    public function getWdate()
    {
        return $this->wdate;
    }

    /**
     * Set Temperature
     *
     * @param int $temperature
     * @return Weather
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * Get Temperature
     *
     * @return int $temperature
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return Weather
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get Description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
