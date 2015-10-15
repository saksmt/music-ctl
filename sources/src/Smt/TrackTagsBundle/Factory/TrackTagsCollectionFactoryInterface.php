<?php

namespace Smt\TrackTagsBundle\Factory;

use Smt\TrackTagsBundle\Entity\AbstractTagsCollection;

/**
 * Track factory
 * @package Smt\TrackTagsBundle\Factory
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface TrackTagsCollectionFactoryInterface
{
    /**
     * @return AbstractTagsCollection
     */
    public function createTrack();
}
