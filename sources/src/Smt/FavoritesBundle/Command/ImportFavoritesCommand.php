<?php

namespace Smt\FavoritesBundle\Command;

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
        if (!$file->isFile()) {
            $out->writeln('<error>File doesn\'t exist!</error>');
            return;
        }
        if (!$file->isReadable()) {
            $out->writeln('<error>Permission denied!</error>');
            return;
        }
        $file = $file->openFile();
        $importer = $this->getContainer()->get('smt.favorites.importer');
        /** @var DecoderInterface $decoder */
        $decoder = $this->getContainer()->get('smt.favorites.coder_registry')->getDecoder($in->getOption('format'));
        if (!isset($decoder)) {
            $available = $this->getContainer()->get('smt.favorites.coder_registry')->getAvailableDecoderNames();
            $out->writeln('Available decoders:');
            foreach ($available as $decoderName) {
                $out->writeln(sprintf(' <info>*</info> %s', $decoderName));
            }
            $out->writeln(sprintf('<error>Decoder with name "%s" not found!</error>', $in->getOption('format')));
            return;
        }
        $mergeStrategy = $this->getContainer()->get('smt.favorites.merge_strategy_registry')->get($in->getOption('merge-strategy'));
        if (!isset($mergeStrategy)) {
            $available = $this->getContainer()->get('smt.favorites.merge_strategy_registry')->getAvailableNames();
            $out->writeln('Available merge strategies:');
            foreach ($available as $strategyName) {
                $out->writeln(sprintf(' <info>*</info> %s', $strategyName));
            }
            $out->writeln(sprintf('<error>Merge strategy with name "%s" not found!</error>', $in->getOption('merge-strategy')));
            return;
        }
        $importer->setStrategy($mergeStrategy);
        $importer
            ->import($decoder->decodeCollection(file_get_contents($file->getPathname())))
            ->flush()
        ;
        $out->writeln(sprintf('<info>Successfully imported %d tracks!</info>', $importer->getTotal()));
    }
}