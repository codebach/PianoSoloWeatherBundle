<?php

namespace PianoSolo\WeatherBundle\Service\HttpClient;

use Guzzle\Http\Client;

class GuzzleHttpClient implements HttpClientInterface
{
	/**
	 * @var Client
	 */
	private $client;
	
	public function __construct()
	{
		$this->client = new Client();
	}
	
	/**
	 * @{inheritdoc}
	 */
	public function getResponseBody($url)
	{
		$request = $this->client->get($url);
		$response = $request->send();
		
		return $response->getBody();
	}
}
