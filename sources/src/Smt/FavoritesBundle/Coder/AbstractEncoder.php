<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

abstract class AbstractEncoder implements EncoderInterface
{
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