<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * JSON format encoder/decoder
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirill.saksin@billing.ru>
 */
class JsonCoder extends AbstractCoder
{

    /** {@inheritdoc} */
    public function decode($data)
    {
        return $this->createTrack(json_decode($data, true));
    }

    /** {@inheritdoc} */
    public function decodeCollection($data)
    {
        return array_map([$this, 'createTrack'], json_decode($data, true));
    }

    /** {@inheritdoc} */
    public function encode(Track $track)
    {
        return json_encode($this->flatten($track));
    }

    /** {@inheritdoc} */
    public function encodeCollection(array $tracks)
    {
        return json_encode(array_map([$this, 'flatten'], $tracks));
    }
}
