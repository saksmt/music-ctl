<?php

namespace Smt\FavoritesBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
use Smt\Component\Console\Style\KernelStyle;
use Smt\Component\Console\Test\VisualTest;
use Smt\FavoritesBundle\Entity\Track;
use Doctrine\Common\Persistence\ObjectManager;
use Smt\FavoritesBundle\Parser\OrderParser;
use Smt\TrackTagsBundle\Formatter\DefaultTrackFormatter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Command to list favorites
 * @package Smt\FavoritesBundle\Command
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class ListFavoritesCommand extends ContainerAwareCommand
{

    /** {@inheritdoc} */
    public function configure()
    {
        $this
            ->setName('favorites:list')
            ->setDescription('List favorites.')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Page number.', 1)
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit of rows.', 5)
            ->addOption('id', null, InputOption::VALUE_NONE, 'Show id\'s')
            // s - skip, a - accept (set saved), e - exit
            ->addOption('save-mode', null, InputOption::VALUE_NONE, 'Display only "unsaved" favorites one-by-one with editing functionality.')
            ->addOption('display-saved', 'S', InputOption::VALUE_NONE, 'Display "saved" properties.')
            ->addOption('path', 'P', InputOption::VALUE_NONE, 'Display paths.')
            ->addOption('rating', 'r', InputOption::VALUE_NONE, 'Display ratings.')
            ->addOption('order', 'o', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Order of tracks', [
                'popularity',
                'artist',
                'album',
                'title',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable) $in
     */
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $out = new GentooStyle($out, $in);
        if ($in->getOption('save-mode')) {
            $this->runSaveMode($in, $out);
            return;
        }
        /** @var ObjectManager $manager */
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $manager->getRepository('SmtFavoritesBundle:Track');
        $parser = new OrderParser($in->getOption('order'));
        $tracks = $repo->findLimited($in->getOption('page'), $in->getOption('limit'), $parser);
        if (empty($tracks)) {
            $out->info('No tracks on this page.');
            return;
        }
        $this->renderTable($in, $out, $this->createHeaders($in), $tracks);
    }

    /**
     * @param InputInterface $in Input
     * @param OutputInterface $out Output
     * @SuppressWarnings(PHPMD.ShortVariable) $in
     */
    private function runSaveMode(InputInterface $in, OutputInterface $out)
    {
        $out = new GentooStyle($out, $in);
        /** @var ObjectManager $manager */
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $manager->getRepository('SmtFavoritesBundle:Track');
        /** @var Track[] $tracks */
        $tracks = $repo->findUnsaved();
        $formatter = new DefaultTrackFormatter();
        $formatter->setFormat('%artist [%album] - %t (%f)');
        // n - skip, s - accept (set saved), e - exit
        $saved = 0;
        foreach ($tracks as $track) {
            $answer = $out->choice(
                $formatter->format($track),
                ['n' => 'Next', 's' => 'Save', 'e' => 'Exit'],
                'n'
            );
            if ($answer == 'Save') {
                $manager->persist($track->save());
                $saved++;
            } elseif ($answer == 'Exit') {
                break;
            }
        }
        $manager->flush();
        $total = count($tracks);
        $out->success(sprintf(
            'Saved <info>%d</info>, Skipped <info>%d</info>, Total: <info>%d</info>',
            $saved,
            $total - $saved,
            $total
        ));
    }

    /**
     * @param InputInterface $in Input
     * @param OutputInterface $out Output
     * @param string[] $headers Table headers
     * @param Track[] $tracks Tracks (table content)
     * @SuppressWarnings(PHPMD.ShortVariable) $in
     */
    private function renderTable(InputInterface $in, OutputInterface $out, array $headers, array $tracks)
    {
        $tbl = new Table($out);
        $tbl->setHeaders($headers);
        $tbl->setRows(array_map(function (Track $track) use ($in) {
            $data = [];
            if ($in->getOption('id')) {
                $data[] = $track->getId();
            }
            $data = array_merge($data, [
                $track->getArtist(),
                $track->getAlbum(),
                $track->getTitle(),
            ]);
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

    /**
     * @param InputInterface $in Input
     * @return string[]
     * @SuppressWarnings(PHPMD.ShortVariable) $in
     */
    private function createHeaders(InputInterface $in)
    {
        $headers = [];
        if ($in->getOption('id')) {
            $headers[] = '#';
        }
        $headers = array_merge($headers, [
            'Artist',
            'Album',
            'Title',
        ]);
        if ($in->getOption('path')) {
            $headers[] = 'Path';
        }
        if ($in->getOption('rating')) {
            $headers[] = 'Rating';
        }
        if ($in->getOption('display-saved')) {
            $headers[] = 'Saved';
            return $headers;
        }
        return $headers;
    }
}
