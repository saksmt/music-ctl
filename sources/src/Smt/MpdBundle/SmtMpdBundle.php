<?php

namespace Smt\MpdBundle;

use Smt\MpdBundle\DependencyInjection\Compiler\ConfigurationsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle
 * @auto-generated
 * @package Smt\MpdBundle
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class SmtMpdBundle extends Bundle
{
    /** {@inheritdoc} */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConfigurationsCompilerPass());
    }
}
