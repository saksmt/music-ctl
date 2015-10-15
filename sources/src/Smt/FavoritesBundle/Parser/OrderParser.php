<?php

namespace Smt\FavoritesBundle\Parser;

/**
 * Parses order
 * @package Smt\FavoritesBundle\Parser
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class OrderParser
{
    const ORDER_ASC = true;
    const ORDER_DESC = false;

    /**
     * @var string[] Map of valid order definitions
     */
    private static $validOrders = [
        'popularity' => ['rating', false],
        'addition' => ['id', false],
        'artist',
        'title',
        'album',
    ];

    /**
     * @var string[][]
     */
    private $order;

    /**
     * Constructor.
     * @param array $order Source order
     */
    public function __construct(array $order)
    {
        $this->order = $this->parseNatives($order);
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
            $result[] = $alias . $order[0] . ($order[1] === self::ORDER_ASC ? 'ASC' : 'DESC');
        }
        return implode(',', $result);
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
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) It's used in array_map
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
            $arrayOrder = [$order, $reverse];
        }
        if (isset(self::$validOrders[$order])) {
            $arrayOrder = self::$validOrders[$order];
            $arrayOrder[1] ^= $reverse;
        }
        return $arrayOrder;
    }
}
