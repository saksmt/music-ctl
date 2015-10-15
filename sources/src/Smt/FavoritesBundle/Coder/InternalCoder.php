<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Encoder/Decoder with internal format (PHP-serialization)
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class InternalCoder extends AbstractCoder
{

    /** {@inheritdoc} */
    public function decode($data)
    {
        $data = unserialize(gzdecode($data));
        return $this->createTrack($data);
    }

    /** {@inheritdoc} */
    public function encode(Track $track)
    {
        return gzencode(serialize($this->flatten($track)));
    }

    /** {@inheritdoc} */
    public function decodeCollection($data)
    {
        $data = unserialize(gzdecode($data));
        return array_map([$this, 'createTrack'], $data);
    }

    /** {@inheritdoc} */
    public function encodeCollection(array $tracks)
    {
        $data = array_map([$this, 'flatten'], $tracks);
        return gzencode(serialize($data));
    }
}
