<?php

namespace Smt\FavoritesBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
use Smt\FavoritesBundle\Coder\DecoderInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportFavoritesCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:import')
            ->setDescription('Import favorites')
            ->addArgument('file', InputArgument::REQUIRED, 'File to import')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Imported file format (decoder)', 'internal')
            ->addOption('merge-strategy', 'm', InputOption::VALUE_REQUIRED, 'Strategy to merge existing tracks', 'average')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $file = new \SplFileInfo($in->getArgument('file'));
        $out = new GentooStyle($out, $in);
        if (!$file->isFile()) {
            $out->error('File doesn\'t exist!');
            return;
        }
        if (!$file->isReadable()) {
            $out->error('Permission denied!');
            return;
        }
        $file = $file->openFile();
        $importer = $this->getContainer()->get('smt.favorites.importer');
        /** @var DecoderInterface $decoder */
        $decoder = $this->getContainer()->get('smt.favorites.coder_registry')->getDecoder($in->getOption('format'));
        if (!isset($decoder)) {
            $available = $this->getContainer()->get('smt.favorites.coder_registry')->getAvailableDecoderNames();
            $out
                ->error(sprintf('Decoder with name "%s" not found!', $in->getOption('format')))
                ->newLine()
                ->info('Available decoders:')
                ->nestedList($available)
            ;
            return;
        }
        $mergeStrategy = $this->getContainer()->get('smt.favorites.merge_strategy_registry')->get($in->getOption('merge-strategy'));
        if (!isset($mergeStrategy)) {
            $available = $this->getContainer()->get('smt.favorites.merge_strategy_registry')->getAvailableNames();
            $out
                ->error(sprintf('Merge strategy with name "%s" not found!', $in->getOption('merge-strategy')))
                ->newLine()
                ->info('Available merge strategies:')
                ->nestedList($available)
            ;
            return;
        }
        $importer->setStrategy($mergeStrategy);
        $importer
            ->import($decoder->decodeCollection(file_get_contents($file->getPathname())))
            ->flush()
        ;
        $out->success(sprintf('Successfully imported %d tracks!', $importer->getTotal()));
    }
}