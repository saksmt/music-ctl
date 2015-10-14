<?php

namespace AppBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
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
        $out = new GentooStyle($out, $in);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = $em->getRepository('AppBundle:MusicTodo')->find($in->getArgument('id'));
        if (!isset($todo)) {
            $out->error('There is no music-todo with specified ID!');
            return -1;
        }
        $em->remove($todo);
        $em->flush($todo);
        $out->success('Successfully ended todo!');
        return 0;
    }
}