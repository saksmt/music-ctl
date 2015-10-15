<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Base extension for configuration
 * @package AppBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class AppExtension extends Extension
{

    /** {@inheritdoc} */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $configDefinition = $container->getDefinition('mpd.config');
        if (isset($config['mpd']['host'])) {
            $configDefinition->addMethodCall('setHost', [$config['mpd']['host']]);
        }
        if (isset($config['mpd']['port'])) {
            $configDefinition->addMethodCall('setPort', [$config['mpd']['port']]);
        }
        if (isset($config['mpd']['password']) && !empty($config['mpd']['password'])) {
            $configDefinition->addMethodCall('setPassword', [$config['mpd']['password']]);
        }
    }
}
