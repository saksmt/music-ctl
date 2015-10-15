<?php

namespace Smt\TrackTagsBundle\Provider;

use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;

/**
 * Provides current track
 * @package Smt\TrackTagsBundle\Provider
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface TrackProviderInterface
{
    /**
     * @return TrackTagsCollectionInterface
     */
    public function get();
}
