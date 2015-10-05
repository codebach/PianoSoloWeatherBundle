<?php

namespace PianoSolo\WeatherBundle\Service\HttpClient;

interface HttpClientInterface
{
	/**
	 * @param string $url
	 * @return string response body
	 */
	public function getResponseBody($url);
}
