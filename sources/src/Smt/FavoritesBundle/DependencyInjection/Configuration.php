<?php

namespace Smt\FavoritesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 * @auto-generated
 * @package Smt\FavoritesBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Configuration implements ConfigurationInterface
{

    /** {@inheritdoc} */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $rootNode = $tree->root('smt_favorites');
        return $rootNode->end();
    }
}
