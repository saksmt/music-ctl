<?php

namespace Smt\TrackTagsBundle;

use Smt\TrackTagsBundle\DependencyInjection\Compiler\TrackProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle
 * @auto-generated
 * @package Smt\TrackTagsBundle
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class SmtTrackTagsBundle extends Bundle
{
    /** {@inheritdoc} */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TrackProviderCompilerPass());
    }
}
