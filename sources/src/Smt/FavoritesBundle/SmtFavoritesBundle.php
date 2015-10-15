<?php

namespace Smt\FavoritesBundle;

use Smt\FavoritesBundle\DependencyInjection\Compiler\FavoritesDecoderPass;
use Smt\FavoritesBundle\DependencyInjection\Compiler\FavoritesEncoderPass;
use Smt\FavoritesBundle\DependencyInjection\Compiler\FavoritesMergeStrategyPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle
 * @auto-generated
 * @package Smt\FavoritesBundle
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class SmtFavoritesBundle extends Bundle
{
    /** {@inheritdoc} */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new FavoritesEncoderPass())
            ->addCompilerPass(new FavoritesDecoderPass())
            ->addCompilerPass(new FavoritesMergeStrategyPass())
        ;
    }
}
