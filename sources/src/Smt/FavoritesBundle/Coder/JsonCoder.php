<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

class JsonCoder extends AbstractCoder
{

    /**
     * @param string $data
     * @return Track
     */
    public function decode($data)
    {
        return $this->createTrack(json_decode($data, true));
    }

    /**
     * @param string $data
     * @return Track[]
     */
    public function decodeCollection($data)
    {
        return array_map([$this, 'createTrack'], json_decode($data, true));
    }

    /**
     * @param Track $track
     * @return string
     */
    public function encode(Track $track)
    {
        return json_encode($this->flatten($track));
    }

    /**
     * @param Track[] $tracks
     * @return string
     */
    public function encodeCollection(array $tracks)
    {
        return json_encode(array_map([$this, 'flatten'], $tracks));
    }
}