<?php

namespace AppBundle\Command;

use AppBundle\Entity\Track;
use Doctrine\Common\Persistence\ObjectManager;
use Smt\TrackTagsBundle\Formatter\DefaultTrackFormatter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ListFavoritesCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:list')
            ->setDescription('List favorites.')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Page number.', 1)
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit of rows.', 5)
            // s - skip, a - accept (set saved), e - exit
            ->addOption('save-mode', null, InputOption::VALUE_NONE, 'Display only "unsaved" favorites one-by-one with editing functionality.')
            ->addOption('display-saved', 'S', InputOption::VALUE_NONE, 'Display "saved" properties.')
            ->addOption('path', 'P', InputOption::VALUE_NONE, 'Display paths.')
            ->addOption('rating', 'r', InputOption::VALUE_NONE, 'Display ratings.')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        if ($in->getOption('save-mode')) {
            $this->runSaveMode($in, $out);
            return;
        }
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('AppBundle:Track');
        $tracks = $repo->findLimited($in->getOption('page'), $in->getOption('limit'));
        if (empty($tracks)) {
            $out->write('<info>No tracks on this page.');
            for ($i = 0; $i < 2; $i++) {
                usleep(250000);
                $out->write('.');
            }
            $out->writeln('</info>');
            return;
        }
        $tbl = new Table($out);
        $headers = [
            'Artist',
            'Album',
            'Title',
        ];
        if ($in->getOption('path')) {
            $headers[] = 'Path';
        }
        if ($in->getOption('rating')) {
            $headers[] = 'Rating';
        }
        if ($in->getOption('display-saved')) {
            $headers[] = 'Saved';
        }
        $tbl->setHeaders($headers);
        $tbl->setRows(array_map(function (Track $track) use ($in) {
            $data = [
                $track->getArtist(),
                $track->getAlbum(),
                $track->getTitle(),
            ];
            if ($in->getOption('path')) {
                $data[] = $track->getPath();
            }
            if ($in->getOption('rating')) {
                $data[] = $track->getRating() + 1;
            }
            if ($in->getOption('display-saved') && $track->isSaved()) {
                $data[] = '*';
            }
            return $data;
        }, $tracks));
        $tbl->render();
    }

    private function runSaveMode(InputInterface $in, OutputInterface $out)
    {
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('AppBundle:Track');
        /** @var Track[] $tracks */
        $tracks = $repo->findUnsaved();
        $formatter = new DefaultTrackFormatter();
        $formatter->setFormat('%artist [%album] - %t (%f)');
        $questionHelper = new QuestionHelper();
        // n - skip, s - accept (set saved), e - exit
        $saved = 0;
        foreach ($tracks as $track) {
            $question = new ChoiceQuestion($formatter->format($track), ['n' => 'Next', 's' => 'Save', 'e' => 'Exit'], 'n');
            $answer = $questionHelper->ask($in, $out, $question);
            if ($answer == 's') {
                $em->persist($track->save());
                $saved++;
            } elseif ($answer == 'e') {
                break;
            }
        }
        $em->flush();
        $total = count($tracks);
        $out->write(sprintf('Saved <info>%d</info>, Skipped <info>%d</info>, Total: <info>%d</info>',
            $saved,
            $total - $saved,
            $total));
    }
}