<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Base class for encoders+decoders
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
abstract class AbstractCoder implements EncoderInterface, DecoderInterface
{
    /**
     * @param array $data Flat track data
     * @return Track
     */
    protected function createTrack(array $data)
    {
        return (new Track())
            ->setSaved($data['saved'])
            ->setRating($data['rating'])
            ->setAlbum($data['album'])
            ->setArtist($data['artist'])
            ->setFile($data['path'])
            ->setTitle($data['title']);
    }

    /**
     * @param Track $track
     * @return array Flattened track
     */
    protected function flatten(Track $track)
    {
        return [
            'album' => $track->getAlbum(),
            'artist' => $track->getArtist(),
            'path' => $track->getFile(),
            'title' => $track->getTitle(),
            'saved' => $track->isSaved(),
            'rating' => $track->getRating(),
        ];
    }
}
