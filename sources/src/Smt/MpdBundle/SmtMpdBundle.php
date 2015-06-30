<?php

namespace Smt\MpdBundle;

use Smt\MpdBundle\DependencyInjection\Compiler\ConfigurationsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SmtMpdBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConfigurationsCompilerPass());
    }
}