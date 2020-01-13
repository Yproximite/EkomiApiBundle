<?php

declare(strict_types=1);

namespace spec\Yproximite\Bundle\EkomiApiBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Yproximite\Bundle\EkomiApiBundle\DependencyInjection\YproximiteEkomiApiExtension;
use Yproximite\Ekomi\Api\Client\Client;
use Yproximite\Ekomi\Api\Service\ServiceAggregator;

class YproximiteEkomiApiExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(YproximiteEkomiApiExtension::class);
    }

    public function it_should_load(ContainerBuilder $container)
    {
        $configs = [
            'yproximite_ekomi_api' => [
                'http_client' => 'httplug.client.guzzle6',
                'client_id'   => 'xxxx',
                'secret_key'  => 'yyyy',
                'base_url'    => 'http://api.host.com',
            ],
        ];

        $container->setAlias('yproximite.ekomi_api.http_client', 'httplug.client.guzzle6')->shouldBeCalled();

        $arguments = [
            new Reference('yproximite.ekomi_api.http_client'),
            'xxxx',
            'yyyy',
            'http://api.host.com',
            null,
            null,
            'yproximite.ekomi.cache_key',
        ];

        $client = new Definition(Client::class, $arguments);
        $client->setPublic(false);

        $container->setDefinition('yproximite.ekomi_api.client', $client)->shouldBeCalled();

        $clientRef  = new Reference('yproximite.ekomi_api.client');
        $aggregator = new Definition(ServiceAggregator::class, [$clientRef]);
        $aggregator->setPublic(true);

        $container->setDefinition('yproximite.ekomi_api.service_aggregator', $aggregator)->shouldBeCalled();

        $this->load($configs, $container);
    }
}
