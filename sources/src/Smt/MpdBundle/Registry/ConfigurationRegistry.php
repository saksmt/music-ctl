<?php

namespace Smt\MpdBundle\Registry;

use Smt\MpdBundle\Configuration\HostConfiguration;
use Smt\MpdBundle\Exception\ConfigurationNotFoundException;

/**
 * Registry for host configurations
 * @package Smt\MpdBundle\Registry
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class ConfigurationRegistry
{
    private $configurations = [];

    /**
     * @param string $name Configuration name
     * @param HostConfiguration $config Configuration
     * @return ConfigurationRegistry
     */
    public function addConfiguration($name, HostConfiguration $config)
    {
        $this->configurations[$name] = $config;
        return $this;
    }

    /**
     * @param HostConfiguration[] $configs List of configurations
     * @return ConfigurationRegistry
     */
    public function addConfigurations(array $configs)
    {
        foreach ($configs as $name => $config) {
            $this->addConfiguration($name, $config);
        }
        return $this;
    }

    /**
     * @param string $name Configuration name
     * @return HostConfiguration
     * @throws ConfigurationNotFoundException
     */
    public function get($name)
    {
        if (isset($this->configurations[$name])) {
            return $this->configurations[$name];
        }
        throw new ConfigurationNotFoundException(sprintf('Configuration with name "%s" not found!', $name));
    }
}
