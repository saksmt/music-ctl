<?php

namespace AppBundle\Command;

use AppBundle\Entity\MusicTodo;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListTodosCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('todo:list')
            ->setDescription('List music-related todo`s')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Number of page.', 1)
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit of rows in table', 5)
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $page = $in->getOption('page');
        $limit = $in->getOption('limit');
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $items = array_map(function (MusicTodo $item) {
            return [
                $item->getId(),
                $item->getArtist(),
                $item->getNote(),
                $item->getStatusName(),
            ];
        }, $em->getRepository('AppBundle:MusicTodo')->findLimited($page, $limit));
        if (!count($items) && $page == 1) {
            $out->writeln($out->getFormatter()->format('<info>No todo`s have been added yet. Try to use "todo:add" first.</info>'));
            return;
        }
        $tbl = new Table($out);
        $tbl->setHeaders(['#', 'Artist', 'Note', 'Status']);
        $tbl->setRows($items);
        $tbl->render();
    }
}