<?php

namespace Smt\TrackTagsBundle\Formatter;

use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;

interface TrackFormatterInterface
{
    /**
     * @param TrackTagsCollectionInterface $track
     * @return string
     */
    public function format(TrackTagsCollectionInterface $track);

    /**
     * @param string $format
     * @return TrackFormatterInterface
     */
    public function setFormat($format);
}