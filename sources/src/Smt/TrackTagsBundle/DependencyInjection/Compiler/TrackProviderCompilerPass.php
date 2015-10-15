<?php

namespace Smt\TrackTagsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers track providers
 * @package Smt\TrackTagsBundle\DependencyInjection\Compiler
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class TrackProviderCompilerPass implements CompilerPassInterface
{

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('smt_track_tags')[0];
        if (isset($config['provider']['default'])) {
            $trackProviders = $container->findTaggedServiceIds('track-provider');
            $lastProvider = null;
            foreach ($trackProviders as $serviceId => $attributes) {
                if (in_array($config['provider']['default'], $attributes)) {
                    $container->setAlias('track.provider', $serviceId);
                    return;
                }
                $lastProvider = $serviceId;
            }
            $container->setAlias('track.provider', $lastProvider);
        }
    }
}
