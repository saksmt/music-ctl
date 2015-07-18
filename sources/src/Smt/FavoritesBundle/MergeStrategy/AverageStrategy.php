<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

class AverageStrategy implements MergeStrategyInterface
{

    public function merge(Track $source, Track $new)
    {
        $source->setRating(
            ($source->getRating() + $new->getRating()) / 2
        )->setSaved(
            $source->isSaved() || $new->isSaved()
        );
    }
}