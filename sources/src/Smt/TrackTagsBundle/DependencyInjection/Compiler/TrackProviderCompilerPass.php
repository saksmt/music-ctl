<?php

namespace Smt\TrackTagsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TrackProviderCompilerPass implements CompilerPassInterface
{

    /** @inheritdoc */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('smt_track_tags')[0];
        if (isset($config['provider']['default'])) {
            $trackProviders = $container->findTaggedServiceIds('track-provider');
            $lastProvider = null;
            foreach ($trackProviders as $serviceId => $attributes) {
                if (in_array($config['provider']['default'], $attributes)) {
                    $this->createProvider($serviceId, $container);
                    return;
                }
                $lastProvider = $serviceId;
            }
            $this->createProvider($lastProvider, $container);
        }
    }

    private function createProvider($serviceId, ContainerBuilder $container)
    {
        $service = $container->getDefinition($serviceId);
        $defaultProvider = new Definition($service->getClass(), $service->getArguments());
        $defaultProvider->setMethodCalls($service->getMethodCalls());
        $container->setDefinition('track.provider', $defaultProvider);
    }
}