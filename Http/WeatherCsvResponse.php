<?php

namespace PianoSolo\WeatherBundle\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Creates a CSV Response of Weather List
 * 
 * @author Ahmet Akbana
 */
class WeatherCsvResponse extends Response
{
    /**
     * @var array
     */
    protected $weathers;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * Set weathers and file name
     *
     * @param array $weathers
     * @param mixed (integer|string) $fileName
     */
    public function __construct(array $weathers, $fileName)
    {
        parent::__construct();

        $this->weathers = $weathers;
        $this->fileName = $fileName;
    }

    /**
     * Creates CSV Response of Weathers
     *
     * @return Response
     */
    public function createCsvResponse()
    {
        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, array('Date', 'City', 'Temperature', 'Description'));
        foreach ($this->weathers as $weather) {
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

        $this->setCharset('ISO-8859-2');
        $this->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $this->headers->set('Content-Description', 'File Transfer');
        $this->headers->set('Content-Disposition', sprintf('attachment; filename="%s.csv"', $this->fileName));

        return $this->setContent($content);
    }
}
