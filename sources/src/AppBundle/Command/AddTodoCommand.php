<?php

namespace AppBundle\Command;

use AppBundle\Entity\MusicTodo;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddTodoCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('todo:add')
            ->setDescription('Add todo item')
            ->addArgument('artist', InputArgument::REQUIRED, 'Artist|Group name')
            ->addArgument('note', InputArgument::OPTIONAL, 'Additional note')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        /**
         * @var ObjectManager $em
         */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = new MusicTodo();
        $todo
            ->setArtist($in->getArgument('artist'))
            ->setNote($in->getArgument('note'))
        ;
        $em->persist($todo);
        $em->flush();
        $em->refresh($todo);
        $tbl = new Table($out);
        $tbl
            ->setHeaders(['#', 'Artist', 'Note', 'Status'])
            ->addRow([$todo->getId(), $todo->getArtist(), $todo->getNote(), $todo->getStatusName()])
        ;
        $tbl->render();
    }
}