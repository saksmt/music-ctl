<?php

namespace Application;

use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Application
 * @package Application
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Application extends BaseApplication
{
    const VERSION = '0.0.0';

    /**
     * @var Command[]
     */
    private $commands;

    /**
     * @var string[]
     */
    private $excludeCommands = [];

    /**
     * Constructor.
     * @param KernelInterface $kernel Symfony kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        parent::__construct($kernel);
        if ($kernel->getContainer()->hasParameter('commands.exclude')) {
            $this->excludeCommands = $kernel->getContainer()->getParameter('commands.exclude');
        }
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return 'music-ctl';
    }

    /** {@inheritdoc} */
    public function getVersion()
    {
        return self::VERSION . ($this->getKernel()->getEnvironment() !== 'prod' ? ' ' . $this->getKernel()->getEnvironment() : '');
    }

    /** {@inheritdoc} */
    public function all($namespace = null)
    {
        if (isset($namespace)) {
            return parent::all($namespace);
        }
        if (isset($this->commands)) {
            return $this->commands;
        }
        return $this->commands = array_filter(parent::all(), function (Command $command) {
            foreach ($this->excludeCommands as $pattern) {
                if (strpos($command->getName(), $pattern) !== false) {
                    return false;
                }
            }
            return true;
        });
    }
}
