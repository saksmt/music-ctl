<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:export')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Format to export', 'internal')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file, defaults to stdout')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        ;
    }
}