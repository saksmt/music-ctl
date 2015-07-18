<?php

namespace Smt\FavoritesBundle\Registry;

use Smt\FavoritesBundle\Coder\DecoderInterface;
use Smt\FavoritesBundle\Coder\EncoderInterface;

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
     * @param string $alias
     * @param EncoderInterface $encoder
     * @return $this
     */
    public function addEncoder($alias, EncoderInterface $encoder)
    {
        $this->encoders[$alias] = $encoder;
        return $this;
    }

    /**
     * @param string $alias
     * @param DecoderInterface $decoder
     * @return $this
     */
    public function addDecoder($alias, DecoderInterface $decoder)
    {
        $this->decoders[$alias] = $decoder;
        return $this;
    }

    /**
     * @param string $alias
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
     * @param string $alias
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