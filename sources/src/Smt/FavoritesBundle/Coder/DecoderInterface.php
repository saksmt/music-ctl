<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Track decoder
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface DecoderInterface
{
    /**
     * @param string $data String representation of track
     * @return Track Track object
     */
    public function decode($data);

    /**
     * @param string $data String representation of track collection
     * @return Track[] Track collection
     */
    public function decodeCollection($data);
}
