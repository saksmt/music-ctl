<?php

namespace Smt\FavoritesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @brief Tags for merge-strategies
 * @package Smt\FavoritesBundle\DependencyInjection\Compiler
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class FavoritesMergeStrategyPass implements CompilerPassInterface
{

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('smt.favorites.merge_strategy_registry');
        foreach ($container->findTaggedServiceIds('favorites.merge_strategy') as $id => $tags) {
            foreach ($tags as $attributes) {
                $registry->addMethodCall('add', [$attributes['alias'], $container->getDefinition($id)]);
            }
        }
    }
}
