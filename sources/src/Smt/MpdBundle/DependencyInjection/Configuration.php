<?php

namespace Smt\MpdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 * @auto-generated
 * @package Smt\MpdBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Configuration implements ConfigurationInterface
{
    /** {@inheritdoc} */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('smt_mpd');
        return $rootNode->end();
    }
}
