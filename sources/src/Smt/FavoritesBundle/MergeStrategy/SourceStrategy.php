<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

class SourceStrategy implements MergeStrategyInterface
{

    /** @inheritdoc */
    public function merge(Track $source, Track $new)
    {
        // Strategy is applied by design
    }
}