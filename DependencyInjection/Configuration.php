<?php

namespace Grizzlylab\Bundle\DenyRoutesByEnvBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Grizzlylab\Bundle\DenyRoutesByEnvBundle\DependencyInjection
 * @author  Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('grizzlylab_deny_routes_by_env');
        $rootNode
            ->children()
                ->scalarNode('message_type')
                    ->defaultValue('grizzlylab_deny_routes_by_env.danger')
                ->end()
                ->arrayNode('denied_routes')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
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
