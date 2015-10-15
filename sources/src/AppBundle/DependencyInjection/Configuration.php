<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Application configuration
 * @package AppBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Configuration implements ConfigurationInterface
{

    /** {@inheritdoc} */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('app');
        $rootNode
            ->children()
                ->arrayNode('mpd')
                    ->children()
                        ->scalarNode('host')->defaultNull()->end()
                        ->scalarNode('port')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $rootNode->end();
    }
}
