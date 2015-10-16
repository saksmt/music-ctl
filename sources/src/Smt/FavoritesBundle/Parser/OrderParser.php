<?php

namespace Smt\FavoritesBundle\Parser;

/**
 * Parses order
 * @package Smt\FavoritesBundle\Parser
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class OrderParser
{
    const ORDER_ASC = false;
    const ORDER_DESC = true;
    const DEFAULT_ORDER = 'popularity';

    /**
     * @var string[] Map of valid order definitions
     */
    private static $validOrders = [
        'popularity' => ['rating', true],
        'addition' => ['id', true],
        'date' => ['id', false],
        'artist',
        'title',
        'album',
        'id',
    ];

    /**
     * @var string[][]
     */
    private $order;

    /**
     * @var string[]
     */
    private $orderingBy = [];

    /**
     * Constructor.
     * @param array $order Source order
     */
    public function __construct(array $order)
    {
        $this->order = $this->parseNatives($order);
        if (empty($this->order)) {
            $this->order = [$this->parse(self::DEFAULT_ORDER)];
        }
    }

    /**
     * @param string $alias Table alias
     * @return string
     */
    public function getQueryString($alias = '')
    {
        $result = [];
        if ($alias !== '') {
            $alias .= '.';
        }
        foreach ($this->order as $order) {
            $result[] = $alias . $order[0] . ' ' . ($order[1] === self::ORDER_ASC ? 'ASC' : 'DESC');
        }
        return implode(', ', $result);
    }

    /**
     * @return string[]
     */
    public function getOrderingBy()
    {
        return $this->orderingBy;
    }

    /**
     * @param array $order
     * @return array
     */
    private function parseNatives(array $order)
    {
        return array_filter(array_map([$this, 'parse'], $order), function ($order) {
            return isset($order);
        });
    }

    /**
     * @param $order
     * @return array|null
     */
    private function parse($order)
    {
        $reverse = false;
        $order = strtolower($order);
        if (substr($order, 0, 1) === '-') {
            $reverse = !$reverse;
        }
        if (in_array(substr($order, 0, 1), ['-', '+'])) {
            $order = substr($order, 1);
        }
        $arrayOrder = null;
        if (in_array($order, self::$validOrders)) {
            $this->addOrderBy($order, $reverse);
            $arrayOrder = [$order, $reverse];
        }
        if (isset(self::$validOrders[$order])) {
            $this->addOrderBy($order, $reverse);
            $arrayOrder = self::$validOrders[$order];
            $arrayOrder[1] = boolval($arrayOrder[1] ^ $reverse);
        }
        return $arrayOrder;
    }

    /**
     * @param string $order
     * @param bool $reverse
     */
    private function addOrderBy($order, $reverse)
    {
        if ($reverse) {
            $order = 'reversed ' . $order;
        }
        $this->orderingBy[] = $order;
    }
}
