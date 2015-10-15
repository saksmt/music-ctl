<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Track encoder (serializer)
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface EncoderInterface
{
    /**
     * @param Track $track Track object
     * @return string String representation of track
     */
    public function encode(Track $track);

    /**
     * @param Track[] $tracks Collection of tracks
     * @return string String representation of track collection
     */
    public function encodeCollection(array $tracks);
}
