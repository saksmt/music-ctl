<?php

namespace Smt\TrackTagsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SmtTrackTagsExtension extends Extension
{

    /** @inheritdoc */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $this->applyFactoryConfig($config, $container);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function applyFactoryConfig(array $config, ContainerBuilder $container)
    {
        if (isset($config['factory']['target'])) {
            $container->getDefinition('track.factory')->replaceArgument(0, $config['factory']['target']);
        }
        if (isset($config['factory']['class'])) {
            $container->getDefinition('track.factory')->setClass($config['factory']['class']);
        }
    }
}