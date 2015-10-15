<?php

namespace Smt\TrackTagsBundle\Entity;

/**
 * Track as collection of tags
 * @package Smt\TrackTagsBundle\Entity
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface TrackTagsCollectionInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getArtist();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getAlbum();
}
