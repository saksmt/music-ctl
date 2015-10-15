<?php

namespace AppBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Represents command for ending to \bdo's
 * @package AppBundle\Command
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class EndTodoCommand extends ContainerAwareCommand
{
    /** {@inheritdoc} */
    public function configure()
    {
        $this
            ->setName('todo:end')
            ->addArgument('id', InputArgument::REQUIRED, 'ID of todo item')
        ;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable) $in
     */
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $out = new GentooStyle($out, $in);
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = $manager->getRepository('AppBundle:MusicTodo')->find($in->getArgument('id'));
        if (!isset($todo)) {
            $out->error('There is no music-todo with specified ID!');
            return -1;
        }
        $manager->remove($todo);
        $manager->flush($todo);
        $out->success('Successfully ended todo!');
        return 0;
    }
}
