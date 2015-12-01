<?php

namespace Smt\FavoritesBundle\Factory;

use Smt\FavoritesBundle\Entity\Track;
use Smt\TrackTagsBundle\Factory\TrackFactory;

/**
 * Track factory
 * @package Smt\FavoritesBundle\Factory
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class TrackFactory implements TrackFactory
{
    /** {@inheritdoc} */
    public function createTrack()
    {
        return new Track();
    }
}
