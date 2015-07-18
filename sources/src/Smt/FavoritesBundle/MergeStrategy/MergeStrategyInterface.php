<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

interface MergeStrategyInterface
{
    /**
     * Result will be stored in @a $source
     * @param Track $source
     * @param Track $new
     */
    public function merge(Track $source, Track $new);
}