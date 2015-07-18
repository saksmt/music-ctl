<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

abstract class AbstractCoder implements EncoderInterface, DecoderInterface
{
    protected function createTrack(array $data)
    {
        return (new Track())
            ->setAlbum($data['album'])
            ->setArtist($data['artist'])
            ->setPath($data['path'])
            ->setTitle($data['title'])
            ->setSaved($data['saved'])
            ->setRating($data['rating']);
    }

    protected function flatten(Track $track)
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