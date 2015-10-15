<?php

namespace Smt\FavoritesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Extension for favorites bundle
 * @auto-generated
 * @package Smt\FavoritesBundle\DependencyInjection
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class SmtFavoritesExtension extends Extension
{

    /** {@inheritdoc} */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
