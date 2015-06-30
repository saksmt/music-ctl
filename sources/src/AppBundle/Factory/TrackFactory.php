<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Track;
use Smt\TrackTagsBundle\Factory\TrackTagsCollectionFactoryInterface;

class TrackFactory implements TrackTagsCollectionFactoryInterface
{
    /** @inheritdoc */
    public function createTrack()
    {
        return new Track();
    }
}