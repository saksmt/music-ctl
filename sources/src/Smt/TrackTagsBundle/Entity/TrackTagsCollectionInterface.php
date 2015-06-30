<?php

namespace Smt\TrackTagsBundle\Entity;

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