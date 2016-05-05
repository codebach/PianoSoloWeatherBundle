<?php

namespace PianoSolo\WeatherBundle\Service\HttpClient;

/**
 * Client for Requesting api
 * 
 * @author Ahmet Akbana
 */
interface HttpClientInterface
{
    /**
     * @param string $url
     * @return string response body
     */
    public function getResponseBody($url);
}
