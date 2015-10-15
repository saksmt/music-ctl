<?php

namespace Smt\FavoritesBundle\MergeStrategy;

use Smt\FavoritesBundle\Entity\Track;

/**
 * "Ours" merging strategy
 * @package Smt\FavoritesBundle\MergeStrategy
 * @author Kirill Saksin <kirill.saksin@billing.ru>
 */
class SourceStrategy implements MergeStrategyInterface
{

    /** {@inheritdoc} */
    public function merge(Track $source, Track $new)
    {
        // Strategy is applied by design
    }
}
