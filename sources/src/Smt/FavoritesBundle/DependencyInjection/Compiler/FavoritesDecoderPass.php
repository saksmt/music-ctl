<?php

namespace Smt\FavoritesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @brief Tags for decoder services
 * @package Smt\FavoritesBundle\DependencyInjection\Compiler
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class FavoritesDecoderPass implements CompilerPassInterface
{

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('smt.favorites.coder_registry');
        foreach ($container->findTaggedServiceIds('favorites.decoder') as $id => $tag) {
            foreach ($tag as $attributes) {
                $definition->addMethodCall('addDecoder', [$attributes['alias'], $container->getDefinition($id)]);
            }
        }
    }

}
