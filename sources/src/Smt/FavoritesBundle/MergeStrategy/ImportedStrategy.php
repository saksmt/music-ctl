<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

/**
 * "Theirs" merging strategy
 * @package Smt\FavoritesBundle\MergeStrategy
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class ImportedStrategy implements MergeStrategyInterface
{

    /** {@inheritdoc} */
    public function merge(Track $source, Track $new)
    {
        $source
            ->setRating($new->getRating())
            ->setSaved($new->isSaved());
    }
}
