<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Merge track's by average rating
 * @package Smt\FavoritesBundle\MergeStrategy
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class AverageStrategy implements MergeStrategyInterface
{

    /** {@inheritdoc} */
    public function merge(Track $source, Track $new)
    {
        $source->setRating(
            ($source->getRating() + $new->getRating()) / 2
        )->setSaved(
            $source->isSaved() || $new->isSaved()
        );
    }
}
