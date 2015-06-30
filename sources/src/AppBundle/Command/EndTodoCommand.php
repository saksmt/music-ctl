<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EndTodoCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('todo:end')
            ->addArgument('id', InputArgument::REQUIRED, 'ID of todo item')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = $em->getRepository('AppBundle:MusicTodo')->find($in->getArgument('id'));
        if (!isset($todo)) {
            $out->writeln('<error>There is no music-todo with specified ID!</error>');
            return -1;
        }
        $em->remove($todo);
        $em->flush($todo);
        $out->writeln('<success>Successfully ended todo!</success>');
        return 0;
    }
}