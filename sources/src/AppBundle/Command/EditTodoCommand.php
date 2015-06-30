<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class EditTodoCommand extends ContainerAwareCommand
{
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

    public function interact(InputInterface $in, OutputInterface $out)
    {
        if (!$in->getOption('shell')) {
            return;
        }
        $helper = $this->getHelper('question');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('AppBundle:MusicTodo');
        $id = $in->getOption('id');
        if (!isset($id)) {
            $question = new Question('ID of todo:');
            $question->setValidator(function ($answer) use ($repo) {
                if (!is_int($answer)) {
                    throw new \Exception('ID must be integer value!');
                }
                if ($repo->find($answer) === null) {
                    throw new \Exception('There is no todo item with such ID!');
                }
                return $answer;
            });
            $id = $helper->ask($in, $out, $question);
        }
        $todo = $repo->find($id);
        $propertyAccessor = new PropertyAccessor();
        foreach (['artist', 'note', 'statusName'] as $property) {
            if ($in->hasOption($property) && $in->getOption($property) !== null) {
                $propertyAccessor->setValue($todo, $property, $in->getOption($property));
            } else {
                $question = new Question(sprintf('Enter todo`s %s:', $property), $propertyAccessor->getValue($todo, $property));
                $response = $helper->ask($in, $out, $question);
                if ($response != $propertyAccessor->getValue($todo, $property)) {
                    $propertyAccessor->setValue($todo, $property, $response);
                }
            }
        }
        $em->persist($todo);
        $em->flush();
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

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $id = $in->getOption('id');
        if (!isset($id)) {
            $out->getFormatter()->format('<error>No ID specified!</error>');
        }
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $todo = $em->getRepository('AppBundle:MusicTodo')->find($id);
        $propertyAccessor = new PropertyAccessor();
        foreach (['artist', 'note', 'statusName'] as $property) {
            if ($in->hasOption($property) && $in->getOption($property) !== null) {
                $propertyAccessor->setValue($todo, $property, $in->getOption($property));
            }
        }
        $em->persist($todo);
        $em->flush();
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