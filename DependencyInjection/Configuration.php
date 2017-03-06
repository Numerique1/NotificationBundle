<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('numerique1_notification');

        $rootNode
            ->children()
                ->arrayNode('notifications')
                    ->useAttributeAsKey('class')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('reference')->isRequired()->end()
                        ->arrayNode('rules')
                            ->prototype('array')
                            ->children()
                                ->scalarNode('event')->cannotBeEmpty()->end()
                                ->scalarNode('route')->defaultValue('*')->end()
                                ->scalarNode('factory')->cannotBeEmpty()->end()
                                ->variableNode('extra')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}