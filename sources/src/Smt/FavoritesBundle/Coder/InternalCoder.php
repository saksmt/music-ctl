<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

class InternalCoder implements EncoderInterface, DecoderInterface
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

    private function createTrack(array $data)
    {
        return (new Track())
            ->setAlbum($data['album'])
            ->setArtist($data['artist'])
            ->setPath($data['path'])
            ->setTitle($data['title'])
            ->setSaved($data['saved'])
            ->setRating($data['rating']);
    }

    private function flatten(Track $track)
    {
        return [
            'album' => $track->getAlbum(),
            'artist' => $track->getArtist(),
            'path' => $track->getPath(),
            'title' => $track->getTitle(),
            'saved' => $track->isSaved(),
            'rating' => $track->getRating(),
        ];
    }
}