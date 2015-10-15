<?php

namespace Smt\TrackTagsBundle\Entity;

/**
 * Track as collection of tags
 * @package Smt\TrackTagsBundle\Entity
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
abstract class AbstractTagsCollection implements TrackTagsCollectionInterface
{
    /**
     * @var string
     */
    protected $album;

    /**
     * @var string
     */
    protected $artist;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $path;

    /**
     * @return string
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param string $album Album name
     * @return AbstractTagsCollection
     */
    public function setAlbum($album)
    {
        $this->album = $album;
        return $this;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param string $artist Artist name
     * @return AbstractTagsCollection
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title Track title
     * @return AbstractTagsCollection
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path Path to track
     * @return AbstractTagsCollection
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
}
