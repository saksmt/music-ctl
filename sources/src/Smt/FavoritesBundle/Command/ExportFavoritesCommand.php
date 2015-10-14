<?php

namespace Smt\FavoritesBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
use Smt\FavoritesBundle\Coder\EncoderInterface;
use Smt\FavoritesBundle\Entity\Track;
use AppBundle\Stream\FileStream;
use AppBundle\Stream\StdOutStream;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportFavoritesCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:export')
            ->setDescription('Export favorites')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Format to export (encoder)', 'internal')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file, defaults to stdout', null)
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $stream = new StdOutStream($out);
        $out = new GentooStyle($out, $in);
        if ($in->hasOption('output') && $in->getOption('output') !== null) {
            $stream->redirect(FileStream::fromFilename($in->getOption('output')));
        }
        /** @var Track[] $favorites */
        $favorites = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('SmtFavoritesBundle:Track')
            ->findAll();
        /** @var EncoderInterface $encoder */
        $encoder = $this->getContainer()->get('smt.favorites.coder_registry')->getEncoder($in->getOption('format'));
        if (!isset($encoder)) {
            $available = $this->getContainer()->get('smt.favorites.coder_registry')->getAvailableEncoderNames();
            $out
                ->error(sprintf('Encoder with name "%s" not found!', $in->getOption('format')))
                ->info('Available encoders:')
                ->nestedList($available);
            return;
        }
        $stream->write($encoder->encodeCollection($favorites));
    }
}