<?php

namespace Smt\FavoritesBundle\Command;

use Smt\Component\Console\Style\GentooStyle;
use Smt\FavoritesBundle\Entity\Track;
use Doctrine\Common\Persistence\ObjectManager;
use Smt\TrackTagsBundle\Formatter\DefaultTrackFormatter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddFavoritesCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('favorites:add')
            ->setDescription(
                'Add current track to favorites database.' . PHP_EOL .
                'If track is already in database it will be voted up.'
            )
            ->addOption('no-vote-up', 'N', InputOption::VALUE_NONE, 'Don\'t vote up current track.')
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'Format to output track info. Recognized keywords:' . PHP_EOL .
                ' %artist - Artist name;' . PHP_EOL .
                ' %album - Album name' . PHP_EOL .
                ' %title, %name, %t, %n - Track title' . PHP_EOL .
                ' %path, %file, %p, %f - Path to file',
                '%artist [%album] - %t'
            )
            ->addOption('vote-up-text', null, InputOption::VALUE_REQUIRED, 'Text to write on voteUp.', 'Successfully voted up "%s". Now rating is %d!')
            ->addOption('added-text', null, InputOption::VALUE_REQUIRED, 'Text to write when added to favorites.', 'Successfully added "%s"!')
        ;
    }

    public function execute(InputInterface $in, OutputInterface $out)
    {
        $out = new GentooStyle($out, $in);
        /**
         * @var Track $track
         */
        $track = $this->getContainer()->get('track.provider')->get();
        /**
         * @var ObjectManager $em
         */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('SmtFavoritesBundle:Track');
        /** @var Track $found */
        $found = $repo->findOneBy([
            'album' => $track->getAlbum(),
            'artist' => $track->getArtist(),
            'title' => $track->getTitle(),
        ]);
        $formatter = new DefaultTrackFormatter();
        $formatter->setFormat($in->getOption('format'));
        if (isset($found)) {
            if (!$in->getOption('no-vote-up')) {
                $found->voteUp();
                $em->persist($found);
                $em->flush();
                $out->info(sprintf($in->getOption('vote-up-text'),
                    $formatter->format($found), $found->getRating()+1));
                return;
            } else {
                $out->warning(sprintf('"%s" is already in favorites!', $formatter->format($found)));
            }
        }
        $em->persist($track);
        $em->flush();
        $out->success(sprintf($in->getOption('added-text'), $formatter->format($track)));
    }
}