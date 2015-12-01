<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Base decoder class
 * @package Smt\FavoritesBundle\Coder
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
abstract class AbstractDecoder implements DecoderInterface
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
}
