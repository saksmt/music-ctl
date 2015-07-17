<?php

namespace Smt\FavoritesBundle\Coder;

use Smt\FavoritesBundle\Entity\Track;

interface DecoderInterface
{
    /**
     * @param string $data
     * @return Track
     */
    public function decode($data);

    /**
     * @param string $data
     * @return Track[]
     */
    public function decodeCollection($data);
}