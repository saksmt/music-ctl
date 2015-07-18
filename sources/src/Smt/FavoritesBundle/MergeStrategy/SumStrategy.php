<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

class SumStrategy implements MergeStrategyInterface
{

    /** @inheritdoc */
    public function merge(Track $source, Track $new)
    {
        $source
            ->setRating($source->getRating() + $new->getRating() + 1) // Plus one cause of counting from 0
            ->setSaved($source->isSaved() || $new->isSaved())
        ;
    }
}