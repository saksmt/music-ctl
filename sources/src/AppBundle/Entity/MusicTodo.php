<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MusicTodo
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MusicTodoRepository")
 * @ORM\Table(name="tbl_todo")
 * @SuppressWarnings(PHPMD.ShortVariable) $id
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class MusicTodo
{
    const STATUS_NEW = 0;
    const STATUS_PARTIAL = 1;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="smallint", length=1)
     */
    private $status = self::STATUS_NEW;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $artist;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status To \bdo status (new or partially complete)
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note Additional info
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;
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
     * @param string $artist Artist to find
     * @return $this
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return self::getStatusNames()[$this->status];
    }

    /**
     * @param string $name Status name
     * @return $this
     */
    public function setStatusName($name)
    {
        $map = array_flip(array_map('strtolower', self::getStatusNames()));
        $key = strtolower($name);
        if (!isset($map[$key])) {
            return $this;
        }
        $this->setStatus($map[$key]);
        return $this;
    }

    /**
     * @return string[]
     */
    public static function getStatusNames()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PARTIAL => 'Partial',
        ];
    }
}
