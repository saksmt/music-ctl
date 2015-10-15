<?php

namespace Smt\MpdMpcBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration of bundle
 * @package Smt\MpdMpcBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Configuration implements ConfigurationInterface
{

    /** {@inheritdoc} */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('smt_mpd_mpc');
        $rootNode
            ->children()
                ->arrayNode('configuration')
                    ->children()
                        ->scalarNode('id')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $rootNode->end();
    }
}
