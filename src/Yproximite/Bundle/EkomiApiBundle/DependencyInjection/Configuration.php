<?php

namespace Yproximite\Bundle\EkomiApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('yproximite_ekomi_api');

        $rootNode
            ->children()
                ->scalarNode('client_id')->isRequired()->end()
                ->scalarNode('secret_key')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
