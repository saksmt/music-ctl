<?php

namespace Smt\TrackTagsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 * @package Smt\TrackTagsBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Configuration implements ConfigurationInterface
{

    /** {@inheritdoc} */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('smt_track_tags');
        $rootNode
            ->children()
                ->arrayNode('factory')
                    ->children()
                        ->scalarNode('class')->end()
                        ->scalarNode('target')->end()
                    ->end()
                ->end()
                ->arrayNode('provider')
                    ->children()
                        ->scalarNode('default')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $rootNode->end();
    }
}
