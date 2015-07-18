<?php

namespace Smt\FavoritesBundle\Registry;

use Smt\FavoritesBundle\MergeStrategy\MergeStrategyInterface;

class MergeStrategyRegistry
{
    /**
     * @var MergeStrategyInterface[]
     */
    private $strategies = [];

    /**
     * @param string $name Strategy name
     * @param MergeStrategyInterface $strategy
     * @return $this
     */
    public function add($name, MergeStrategyInterface $strategy)
    {
        $this->strategies[$name] = $strategy;
        return $this;
    }

    /**
     * @param string $name Strategy name
     * @return MergeStrategyInterface
     */
    public function get($name)
    {
        return isset($this->strategies[$name]) ? $this->strategies[$name] : null;
    }

    /**
     * @return string[]
     */
    public function getAvailableNames()
    {
        return array_keys($this->strategies);
    }
}