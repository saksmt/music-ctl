<?php

namespace Smt\FavoritesBundle\Registry;

use Smt\FavoritesBundle\MergeStrategy\MergeStrategyInterface;

/**
 * Registry for merge strategies
 * @package Smt\FavoritesBundle\Registry
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class MergeStrategyRegistry
{
    /**
     * @var MergeStrategyInterface[]
     */
    private $strategies = [];

    /**
     * @param string $name Strategy name
     * @param MergeStrategyInterface $strategy Strategy
     * @return MergeStrategyRegistry
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
