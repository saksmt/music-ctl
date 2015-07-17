<?php

namespace AppBundle\Stream;

/**
 * Represents output stream
 * @package AppBundle\Stream
 */
interface Stream
{
    /**
     * @param array|string $data
     * @return Stream
     */
    public function write($data);

    /**
     * @param array|string $data
     * @return Stream
     */
    public function writeln($data);

    /**
     * Redirect output from this stream to specified one
     * @param Stream $stream
     * @return Stream
     */
    public function redirect(Stream $stream);
}