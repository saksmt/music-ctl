<?php

namespace Smt\TrackTagsBundle\Formatter;

use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;

/**
 * Default track formatter
 * @package Smt\TrackTagsBundle\Formatter
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class DefaultTrackFormatter implements TrackFormatterInterface
{

    /**
     * @var string
     */
    protected $format;

    /**
     * @var callable[]
     */
    private static $formatMap;

    /**
     * @var callable[]
     */
    protected $formatKeys;

    /**
     * @return callable[]
     */
    public static function getFormatKeys()
    {
        if (!isset(self::$formatMap)) {
            $accessor = function ($property) {
                return function (TrackTagsCollectionInterface $track) use ($property) {
                    return $track->{'get' . ucfirst($property)}();
                };
            };
            self::$formatMap = array_map($accessor, [
                '%album' => 'album',
                '%artist' => 'artist',
                '%title' => 'title',
                '%path' => 'path',
                '%file' => 'path',
                '%name' => 'title',
                '%t' => 'title',
                '%f' => 'path',
                '%n' => 'title',
                '%p' => 'path',
            ]);
        }
        return self::$formatMap;
    }

    /** {@inheritdoc} */
    public function format(TrackTagsCollectionInterface $track)
    {
        $formatValues = array_map(function (callable $factory) use ($track) {
            return $factory($track);
        }, $this->formatKeys);
        return str_replace(array_keys($formatValues), $formatValues, $this->format);
    }

    /** {@inheritdoc} */
    public function setFormat($format)
    {
        $formatKeys = [];
        foreach (self::getFormatKeys() as $formatKey => $v) {
            if (strpos($format, $formatKey) !== false) {
                $formatKeys[$formatKey] = $v;
            }
        }
        $this->formatKeys = $formatKeys;
        $this->format = $format;
        return $this;
    }
}
