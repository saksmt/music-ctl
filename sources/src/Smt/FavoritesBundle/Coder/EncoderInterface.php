<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

interface EncoderInterface
{
    /**
     * @param Track $track
     * @return string
     */
    public function encode(Track $track);

    /**
     * @param Track[] $tracks
     * @return string
     */
    public function encodeCollection(array $tracks);
}