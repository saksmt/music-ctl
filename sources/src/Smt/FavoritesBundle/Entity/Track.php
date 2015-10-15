<?php

namespace Smt\FavoritesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Smt\TrackTagsBundle\Entity\AbstractTagsCollection;

/**
 * Represents track
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="Smt\FavoritesBundle\Repository\TrackRepository")
 * @ORM\Table(name="tbl_favorites")
 * @SuppressWarnings(PHPMD.ShortVariable) $id
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class Track extends AbstractTagsCollection
{
    /**
     * @var int
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     */
    private $id;

    /**
     * {@inheritdoc}
     * @ORM\Column(type="string", length=255)
     */
    protected $artist;

    /**
     * {@inheritdoc}
     * @ORM\Column(type="string", length=255)
     */
    protected $path;

    /**
     * {@inheritdoc}
     * @ORM\Column(type="string", length=255)
     */
    protected $album;

    /**
     * {@inheritdoc}
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var int Track rating
     * @ORM\Column(type="smallint", length=2)
     */
    private $rating = 0;

    /**
     * @var bool Whether user already saved track
     * @ORM\Column(type="boolean")
     */
    private $saved = false;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating Track rating
     * @return Track
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return Track
     */
    public function voteUp()
    {
        $this->rating++;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSaved()
    {
        return $this->saved;
    }

    /**
     * @return Track
     */
    public function save()
    {
        $this->saved = true;
        return $this;
    }

    /**
     * @param bool $saved Whether user saved track
     * @return Track
     */
    public function setSaved($saved)
    {
        $this->saved = $saved;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
