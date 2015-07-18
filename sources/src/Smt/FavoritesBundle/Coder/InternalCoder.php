<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

class InternalCoder extends AbstractCoder
{

    /**
     * @param string $data
     * @return Track
     */
    public function decode($data)
    {
        $data = unserialize(gzdecode($data));
        return $this->createTrack($data);
    }

    /**
     * @param Track $track
     * @return string
     */
    public function encode(Track $track)
    {
        return gzencode(serialize($this->flatten($track)));
    }

    /**
     * @param string $data
     * @return Track[]
     */
    public function decodeCollection($data)
    {
        $data = unserialize(gzdecode($data));
        return array_map([$this, 'createTrack'], $data);
    }

    /**
     * @param Track[] $tracks
     * @return string
     */
    public function encodeCollection(array $tracks)
    {
        $data = array_map([$this, 'flatten'], $tracks);
        return gzencode(serialize($data));
    }
}