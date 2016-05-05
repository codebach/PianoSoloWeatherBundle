<?php

namespace PianoSolo\WeatherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 */
class PianoSoloWeatherExtension extends Extension
{
    /**
    * {@inheritdoc}
    */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('pianosolo.weather.api_key', $config['api_key']);
        $container->setParameter('pianosolo.weather.options.download_csv', $config['options']['download_csv']);
        $container->setParameter('pianosolo.weather.options.cache', $config['options']['cache']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
