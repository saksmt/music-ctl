<?php

namespace Smt\TrackTagsBundle\Factory;

use Smt\TrackTagsBundle\Entity\AbstractTagsCollection;

class DefaultTrackTagsCollectionFactory implements TrackTagsCollectionFactoryInterface
{
    /**
     * @var string $targetClass
     */
    private $targetClass;

    public function __construct($targetClass)
    {
        $this->targetClass = $targetClass;
    }

    /** @inheritdoc */
    public function createTrack()
    {
        return new $this->targetClass;
    }
}