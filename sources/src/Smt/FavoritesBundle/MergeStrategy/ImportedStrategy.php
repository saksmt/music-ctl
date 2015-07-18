<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

class ImportedStrategy implements MergeStrategyInterface
{

    /** @inheritdoc */
    public function merge(Track $source, Track $new)
    {
        $source
            ->setRating($new->getRating())
            ->setSaved($new->isSaved());
    }
}