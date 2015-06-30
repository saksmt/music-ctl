<?php

namespace Smt\TrackTagsBundle\Provider;

use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;

interface TrackProviderInterface
{
    /**
     * @return TrackTagsCollectionInterface
     */
    public function get();
}