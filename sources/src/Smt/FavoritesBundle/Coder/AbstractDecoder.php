<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

abstract class AbstractDecoder implements DecoderInterface
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
}