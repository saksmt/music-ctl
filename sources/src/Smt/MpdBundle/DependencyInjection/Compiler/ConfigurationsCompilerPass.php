<?php

namespace Smt\MpdBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationsCompilerPass implements CompilerPassInterface
{

    /** @inheritdoc */
    public function process(ContainerBuilder $container)
    {
        $registryDefinition = $container->getDefinition('mpd.configuration.registry');
        $configurations = $container->findTaggedServiceIds('mpd.configuration');
        foreach ($configurations as $serviceId => $attributes) {
            $registryDefinition->addMethodCall('addConfiguration', [$attributes[0]['id'], $container->getDefinition($serviceId)]);
        }
    }
}