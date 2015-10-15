<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Specifies how to merge 2 tracks
 * @package Smt\FavoritesBundle\MergeStrategy
 * @author Kirill Saksin <kirill.saksin@billing.ru>
 */
interface MergeStrategyInterface
{
    /**
     * Result will be stored in @a $source
     * @param Track $source Source track
     * @param Track $new Imported track
     */
    public function merge(Track $source, Track $new);
}
