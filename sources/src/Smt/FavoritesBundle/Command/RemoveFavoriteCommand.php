<?php

namespace Smt\FavoritesBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Smt\TrackTagsBundle\Formatter\DefaultTrackFormatter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class RemoveFavoriteCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:remove')
            ->setDescription('Remove favorite track')
            ->addArgument('id', InputArgument::REQUIRED, 'ID of track to remove')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force removal without asking')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $track = $em->getRepository('SmtFavoritesBundle:Track')
            ->find($in->getArgument('id'));
        if (!isset($track)) {
            $out->writeln(sprintf('<error>There is no track with ID %d</error>', $in->getArgument('id')));
            return;
        }
        $trackFormatter = new DefaultTrackFormatter();
        $trackFormatter->setFormat('%artist [%album] - %t');
        if (!$in->getOption('force')) {
            $question = new ConfirmationQuestion(sprintf('Remove "%s"? ', $trackFormatter->format($track)), false);
            $questionHelper = new QuestionHelper();
            if (!$questionHelper->ask($in, $out, $question)) {
                return;
            }
        }
        $em->remove($track);
        $em->flush();
        $out->writeln(sprintf('Successfully removed "%s"!', $trackFormatter->format($track)));
    }
}