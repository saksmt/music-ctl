<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TodoCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('todo')
            ->addArgument('action', InputArgument::REQUIRED, '<add|list|edit>')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $action = $in->getArgument('action');
        $command = null;
        try {
            $command = $this->getApplication()->get('todo:' . $action);
        } catch (\InvalidArgumentException $e) {
            $out->writeln(sprintf('<error>Action "%s" doesn\'t exist!</error>', $action));
            return -1;
        }
        /** @var ContainerAwareCommand $command */
        $argsDef = $command->getDefinition();
        $argsDef->setArguments(array_merge(
            [new InputArgument('action', InputArgument::REQUIRED)],
            $argsDef->getArguments()
        ));
        return $command->run($in, $out);
    }
}