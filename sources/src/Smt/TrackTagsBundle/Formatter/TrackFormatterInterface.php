<?php

namespace Smt\TrackTagsBundle\Formatter;

use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;

/**
 * Track-related info formatter
 * @package Smt\TrackTagsBundle\Formatter
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
interface TrackFormatterInterface
{
    /**
     * @param TrackTagsCollectionInterface $track Track to format
     * @return string
     */
    public function format(TrackTagsCollectionInterface $track);

    /**
     * @param string $format Info format
     * @return TrackFormatterInterface
     */
    public function setFormat($format);
}
