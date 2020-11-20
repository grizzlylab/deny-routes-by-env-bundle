<?php

namespace Grizzlylab\Bundle\DenyRoutesByEnvBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('grizzlylab_deny_routes_by_env');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('message_type')
                    ->defaultValue('grizzlylab_deny_routes_by_env.danger')
                ->end()
                ->arrayNode('denied_routes')
                    ->isRequired()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('redirection_route')
                    ->isRequired()
                    ->children()
                        ->scalarNode('name')->end()
                        ->arrayNode('parameters')
                            ->prototype('array')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
