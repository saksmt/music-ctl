<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

/**
 * Summarize rating
 * @package Smt\FavoritesBundle\MergeStrategy
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class SumStrategy implements MergeStrategyInterface
{

    /** {@inheritdoc} */
    public function merge(Track $source, Track $new)
    {
        $source
            ->setRating($source->getRating() + $new->getRating() + 1) // Plus one cause of counting from 0
            ->setSaved($source->isSaved() || $new->isSaved())
        ;
    }
}