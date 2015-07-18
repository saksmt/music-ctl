<?php

namespace Smt\FavoritesBundle\Import;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Smt\FavoritesBundle\Entity\Track;
use Smt\FavoritesBundle\MergeStrategy\MergeStrategyInterface;

class Importer
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var ObjectRepository
     */
    private $repo;

    /**
     * @var MergeStrategyInterface
     */
    private $strategy;

    /**
     * @var int
     */
    private $imported = 0;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repo = $om->getRepository('SmtFavoritesBundle:Track');
    }

    public function setStrategy(MergeStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * @param Track[] $tracks
     * @return $this
     */
    public function import(array $tracks)
    {
        foreach ($tracks as $track) {
            $this->imported++;
            $this->importTrack($track);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function flush()
    {
        $this->om->flush();
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->imported;
    }

    private function importTrack(Track $track)
    {
        /** @var Track $sourceTrack */
        $sourceTrack = $this->repo->findOneBy([
            'title' => $track->getTitle(),
            'album' => $track->getAlbum(),
            'artist' => $track->getArtist(),
        ]);
        if (isset($sourceTrack)) {
            $this->strategy->merge($sourceTrack, $track);
        } else {
            $sourceTrack = $track;
        }
        $this->om->persist($sourceTrack);
    }
}