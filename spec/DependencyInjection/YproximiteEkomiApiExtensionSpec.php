<?php

namespace spec\Yproximite\Bundle\EkomiApiBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Yproximite\Ekomi\Api\Client\Client;
use Yproximite\Ekomi\Api\Service\ServiceAggregator;
use Yproximite\Bundle\EkomiApiBundle\DependencyInjection\YproximiteEkomiApiExtension;

class YproximiteEkomiApiExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(YproximiteEkomiApiExtension::class);
    }

    function it_should_load(ContainerBuilder $container)
    {
        $configs = [
            'yproximite_ekomi_api' => [
                'http_client' => 'httplug.client.guzzle6',
                'client_id'   => 'xxxx',
                'secret_key'  => 'yyyy',
                'base_url'    => 'http://api.host.com',
            ],
        ];

        $container->setAlias(Argument::exact('yproximite.ekomi_api.http_client'), Argument::exact('httplug.client.guzzle6'))->shouldBeCalled();

        $arguments = [new Reference('yproximite.ekomi_api.http_client'), 'xxxx', 'yyyy', 'http://api.host.com'];

        $client = new Definition(Client::class, $arguments);
        $client->setPublic(false);

        $container->setDefinition(Argument::exact('yproximite.ekomi_api.client'), Argument::exact($client))->shouldBeCalled();

        $clientRef  = new Reference('yproximite.ekomi_api.client');
        $aggregator = new Definition(ServiceAggregator::class, [$clientRef]);
        $aggregator->setPublic(true);

        $container->setDefinition(Argument::exact('yproximite.ekomi_api.service_aggregator'), Argument::exact($aggregator))->shouldBeCalled();

        $this->load($configs, $container);
    }
}
