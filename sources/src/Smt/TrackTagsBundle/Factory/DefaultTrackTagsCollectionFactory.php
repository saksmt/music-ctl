<?php

namespace Smt\TrackTagsBundle\Factory;

/**
 * Default track factory
 * @package Smt\TrackTagsBundle\Factory
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class DefaultTrackTagsCollectionFactory implements TrackTagsCollectionFactoryInterface
{
    /**
     * @var string $targetClass
     */
    private $targetClass;

    /**
     * Constructor.
     * @param Class<? extends TrackTagsCollection> $targetClass Class of track
     */
    public function __construct($targetClass)
    {
        $this->targetClass = $targetClass;
    }

    /** {@inheritdoc} */
    public function createTrack()
    {
        return new $this->targetClass();
    }
}
