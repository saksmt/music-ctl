<?php

namespace Smt\MpdBundle\Registry;

use Smt\MpdBundle\Configuration\HostConfiguration;
use Smt\MpdBundle\Exception\ConfigurationNotFoundException;

class ConfigurationRegistry
{
    private $configurations = [];

    /**
     * @param string $name
     * @param HostConfiguration $config
     */
    public function addConfiguration($name, HostConfiguration $config)
    {
        $this->configurations[$name] = $config;
    }

    /**
     * @param HostConfiguration[] $configs
     */
    public function addConfigurations(array $configs)
    {
        foreach ($configs as $name => $config) {
            $this->addConfiguration($name, $config);
        }
    }

    /**
     * @param string $name
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