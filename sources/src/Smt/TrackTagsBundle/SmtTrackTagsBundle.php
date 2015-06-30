<?php

namespace Smt\TrackTagsBundle;

use Smt\TrackTagsBundle\DependencyInjection\Compiler\TrackProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SmtTrackTagsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TrackProviderCompilerPass());
    }
}