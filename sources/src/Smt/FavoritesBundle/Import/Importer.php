<?php

namespace Smt\FavoritesBundle\Import;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Smt\FavoritesBundle\Entity\Track;
use Smt\FavoritesBundle\MergeStrategy\MergeStrategyInterface;

/**
 * Imports tracks to favorites database
 * @package Smt\FavoritesBundle\Import
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Importer
{
    /**
     * @var ObjectManager
     */
    private $manager;

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

    /**
     * Constructor.
     * @param ObjectManager $manager Doctrine manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository('SmtFavoritesBundle:Track');
    }

    /**
     * Set track merging strategy
     * @param MergeStrategyInterface $strategy Merging strategy
     * @return Importer
     */
    public function setStrategy(MergeStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * @param Track[] $tracks Tracks to import
     * @return Importer
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
     * @return Importer
     */
    public function flush()
    {
        $this->manager->flush();
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->imported;
    }

    /**
     * @param Track $track
     */
    private function importTrack(Track $track)
    {
        /** @var Track $sourceTrack */
        $sourceTrack = $this->repo->findOneBy([
            'title' => $track->getTitle(),
            'artist' => $track->getArtist(),
        ]);
        if (isset($sourceTrack)) {
            $this->strategy->merge($sourceTrack, $track);
        } else {
            $sourceTrack = $track;
        }
        $this->manager->persist($sourceTrack);
    }
}
