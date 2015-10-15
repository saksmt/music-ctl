<?php

namespace Smt\FavoritesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @brief Tags for encoders
 * @package Smt\FavoritesBundle\DependencyInjection\Compiler
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class FavoritesEncoderPass implements CompilerPassInterface
{

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('smt.favorites.coder_registry');
        foreach ($container->findTaggedServiceIds('favorites.encoder') as $id => $tag) {
            foreach ($tag as $attributes) {
                $definition->addMethodCall('addEncoder', [$attributes['alias'], $container->getDefinition($id)]);
            }
        }
    }
}
