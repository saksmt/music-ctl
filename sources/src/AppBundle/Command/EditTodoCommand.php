<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Smt\Component\Console\Style\GentooStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Represents command for editing to \bdo
 * @package AppBundle\Command
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class EditTodoCommand extends ContainerAwareCommand
{
    /** {@inheritdoc} */
    public function configure()
    {
        $this
            ->setName('todo:edit')
            ->setDescription('Edit previously added music-related todo item.')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED, 'ID of todo item')
            ->addOption('artist', 'A', InputOption::VALUE_REQUIRED, 'Artist to set')
            ->addOption('note', 'N', InputOption::VALUE_REQUIRED, 'Note to set')
            ->addOption('statusName', 'S', InputOption::VALUE_REQUIRED, 'Status-name to set')
        ;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable) $in, $id
     */
    public function interact(InputInterface $in, OutputInterface $out)
    {
        if (!$in->getOption('shell')) {
            return;
        }
        $out = new GentooStyle($out, $in);
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $manager->getRepository('AppBundle:MusicTodo');
        $id = $in->getOption('id');
        if (!isset($id)) {
            $id = $out->ask('ID of todo:', null, function ($answer) use ($repo) {
                if (!is_int($answer)) {
                    throw new \Exception('ID must be integer value!');
                }
                if ($repo->find($answer) === null) {
                    throw new \Exception('There is no todo item with such ID!');
                }
                return $answer;
            });
        }
        $todo = $repo->find($id);
        $propertyAccessor = new PropertyAccessor();
        foreach (['artist', 'note', 'statusName'] as $property) {
            if ($in->hasOption($property) && $in->getOption($property) !== null) {
                $propertyAccessor->setValue($todo, $property, $in->getOption($property));
            } else {
                $response = $out->ask(sprintf('Enter todo`s %s', $property), $propertyAccessor->getValue($todo, $property));
                if ($response != $propertyAccessor->getValue($todo, $property)) {
                    $propertyAccessor->setValue($todo, $property, $response);
                }
            }
        }
        $manager->persist($todo);
        $manager->flush();
        $tbl = new Table($out);
        $tbl
            ->setHeaders(['#', 'Artist', 'Note', 'Status'])
            ->addRow([
                $todo->getId(),
                $todo->getArtist(),
                $todo->getNote(),
                $todo->getStatusName(),
            ])
            ->render()
        ;
        return;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable) $in, $id
     */
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $out = new GentooStyle($out, $in);
        $id = $in->getOption('id');
        if (!isset($id)) {
            $out->error('No ID Specified!');
        }
        /** @var ObjectManager $manager */
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = $manager->getRepository('AppBundle:MusicTodo')->find($id);
        $propertyAccessor = new PropertyAccessor();
        foreach (['artist', 'note', 'statusName'] as $property) {
            if ($in->hasOption($property) && $in->getOption($property) !== null) {
                $propertyAccessor->setValue($todo, $property, $in->getOption($property));
            }
        }
        $manager->persist($todo);
        $manager->flush();
        $tbl = new Table($out);
        $tbl
            ->setHeaders(['#', 'Artist', 'Note', 'Status'])
            ->addRow([
                $todo->getId(),
                $todo->getArtist(),
                $todo->getNote(),
                $todo->getStatusName(),
            ])
            ->render()
        ;
        return 0;
    }
}
