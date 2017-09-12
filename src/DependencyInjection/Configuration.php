<?php
declare(strict_types=1);

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

        $rootNode = $treeBuilder->root('yproximite_ekomi_api');
        $rootNode
            ->children()
                ->scalarNode('http_client')
                    ->info(sprintf('Identifier of the service that represents "%s"', 'Http\\Client\\HttpClient'))
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('client_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('secret_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('base_url')->cannotBeEmpty()->end()
                ->scalarNode('cache')->cannotBeEmpty()->end()
                ->scalarNode('cache_key')->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
