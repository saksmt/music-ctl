<?php

namespace Smt\FavoritesBundle\Registry;

use Smt\FavoritesBundle\Coder\DecoderInterface;
use Smt\FavoritesBundle\Coder\EncoderInterface;

/**
 * Registry of encoders/decoders
 * @package Smt\FavoritesBundle\Registry
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class CoderRegistry
{
    /**
     * @var EncoderInterface[]
     */
    private $encoders = [];

    /**
     * @var DecoderInterface[]
     */
    private $decoders = [];

    /**
     * @param string $alias Encoder name
     * @param EncoderInterface $encoder Encoder
     * @return CoderRegistry
     */
    public function addEncoder($alias, EncoderInterface $encoder)
    {
        $this->encoders[$alias] = $encoder;
        return $this;
    }

    /**
     * @param string $alias Decoder name
     * @param DecoderInterface $decoder Decoder
     * @return CoderRegistry
     */
    public function addDecoder($alias, DecoderInterface $decoder)
    {
        $this->decoders[$alias] = $decoder;
        return $this;
    }

    /**
     * @param string $alias Encoder name
     * @return EncoderInterface
     */
    public function getEncoder($alias)
    {
        if (!isset($this->encoders[$alias])) {
            return null;
        }
        return $this->encoders[$alias];
    }

    /**
     * @param string $alias Decoder name
     * @return DecoderInterface
     */
    public function getDecoder($alias)
    {
        if (!isset($this->decoders[$alias])) {
            return null;
        }
        return $this->decoders[$alias];
    }

    /**
     * @return string[]
     */
    public function getAvailableDecoderNames()
    {
        return array_keys($this->decoders);
    }

    /**
     * @return string[]
     */
    public function getAvailableEncoderNames()
    {
        return array_keys($this->encoders);
    }
}
