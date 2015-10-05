<?php

namespace PianoSolo\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends Controller
{
    public function indexAction(Request $request)
    {
    	$city = '';
    	$weathers = '';
		
    	if($request->getMethod() == 'POST'){
    		
			$city = $request->get('city');

    	}
		
        return $this->render('PianoSoloWeatherBundle:Weather:index.html.twig', array(
        	'city' => $city
		));
    }
	
	public function generateCsvAction($city){
 
		if ($weathers = $this->get('cache')->fetch($city)) {
		    $weathers = unserialize($weathers);
		} else {
			$weatherHandler = $this->get('pianosolo.weather.handler.weather');
			$weathers = $weatherHandler->getForecast($city);
		    $this->get('cache')->save($city, serialize($weathers), 3600);
		}
		
		if(!empty($weathers)){
		
			$handle = fopen('php://memory', 'r+');
        	$header = array();
		
			fputcsv($handle, array('Date', 'City', 'Temperature', 'Description'));
	        foreach ($weathers as $weather) {
	            fputcsv($handle, array(
	            	$weather->getWdate(),
	            	$weather->getCity(),
	            	$weather->getTemperature(),
	            	$weather->getDescription()
				));
	        }
	
	        rewind($handle);
	        $content = stream_get_contents($handle);
	        fclose($handle);
	        
	        return new Response($content, 200, array(
	            'Content-Type' => 'application/force-download',
	            'Content-Disposition' => 'attachment; filename="'.$city.'.csv"'
	        ));
		
		}else{
			throw $this->createNotFoundException('Page Not Found!');
		}
	}
	
}