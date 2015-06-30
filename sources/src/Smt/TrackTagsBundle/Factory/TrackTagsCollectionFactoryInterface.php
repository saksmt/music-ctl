<?php

namespace Smt\TrackTagsBundle\Factory;

use Smt\TrackTagsBundle\Entity\AbstractTagsCollection;

interface TrackTagsCollectionFactoryInterface
{
    /**
     * @return AbstractTagsCollection
     */
    public function createTrack();
}