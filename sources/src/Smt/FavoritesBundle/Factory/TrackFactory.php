<?php

namespace Smt\FavoritesBundle\Factory;

use Smt\FavoritesBundle\Entity\Track;
use Smt\TrackTagsBundle\Factory\TrackTagsCollectionFactoryInterface;

class TrackFactory implements TrackTagsCollectionFactoryInterface
{
    /** @inheritdoc */
    public function createTrack()
    {
        return new Track();
    }
}