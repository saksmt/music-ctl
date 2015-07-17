<?php

namespace Smt\FavoritesBundle;

use Smt\FavoritesBundle\DependencyInjection\Compiler\FavoritesDecoderPass;
use Smt\FavoritesBundle\DependencyInjection\Compiler\FavoritesEncoderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SmtFavoritesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new FavoritesEncoderPass())
            ->addCompilerPass(new FavoritesDecoderPass());
    }
}