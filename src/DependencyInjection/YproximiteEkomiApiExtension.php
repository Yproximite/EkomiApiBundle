<?php

declare(strict_types=1);

namespace Yproximite\Bundle\EkomiApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Yproximite\Ekomi\Api\Client\Client;
use Yproximite\Ekomi\Api\Service\ServiceAggregator;

/**
 * Class YproximiteEkomiApiExtension
 */
class YproximiteEkomiApiExtension extends Extension
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var array
     */
    private $config;

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();
        $config        = $processor->processConfiguration($configuration, $configs);

        $this->container = $container;
        $this->config    = $config;

        $this->linkHttpClient();
        $this->addClient();
        $this->addServiceAggregator();
    }

    private function linkHttpClient()
    {
        $this->container->setAlias('yproximite.ekomi_api.http_client', $this->config['http_client']);
    }

    private function addClient()
    {
        $arguments = [
            new Reference('yproximite.ekomi_api.http_client'),
            $this->config['client_id'],
            $this->config['secret_key'],
        ];

        if (array_key_exists('base_url', $this->config)) {
            $arguments[] = $this->config['base_url'];
        } else {
            $arguments[] = Client::BASE_URL;
        }

        $arguments[] = null; // MessageFactory

        if (array_key_exists('cache', $this->config)) {
            $arguments[] = new Reference($this->config['cache']);
        } else {
            $arguments[] = null;
        }

        if (array_key_exists('cache_key', $this->config)) {
            $arguments[] = $this->config['cache_key'];
        } else {
            $arguments[] = Client::CACHE_KEY;
        }

        $client = new Definition(Client::class, $arguments);
        $client->setPublic(false);

        $this->container->setDefinition('yproximite.ekomi_api.client', $client);
    }

    private function addServiceAggregator()
    {
        $clientRef  = new Reference('yproximite.ekomi_api.client');
        $aggregator = new Definition(ServiceAggregator::class, [$clientRef]);
        $aggregator->setPublic(true);

        $this->container->setDefinition('yproximite.ekomi_api.service_aggregator', $aggregator);
    }
}
