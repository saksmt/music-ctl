<?php

namespace Smt\MpdBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers host configurations
 * @package Smt\MpdBundle\DependencyInjection\Compiler
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class ConfigurationsCompilerPass implements CompilerPassInterface
{

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $registryDefinition = $container->getDefinition('mpd.configuration.registry');
        $configurations = $container->findTaggedServiceIds('mpd.configuration');
        foreach ($configurations as $serviceId => $attributes) {
            $registryDefinition->addMethodCall('addConfiguration', [$attributes[0]['id'], $container->getDefinition($serviceId)]);
        }
    }
}
