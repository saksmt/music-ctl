<?php

namespace AppBundle\Stream;

abstract class AbstractStream implements Stream
{
    /**
     * @var Stream
     */
    private $redirect;

    /** @inheritdoc */
    public function write($data)
    {
        if (isset($this->redirect)) {
            $this->redirect->write($data);
            return $this;
        }
        if (is_array($data)) {
            $data = implode(PHP_EOL, $data);
        }
        $this->doWrite($data);
        return $this;
    }

    /** @inheritdoc */
    public function writeln($data)
    {
        $this->write($data);
        $this->write(PHP_EOL);
        return $this;
    }

    /** @inheritdoc */
    public function redirect(Stream $stream)
    {
        $this->redirect = $stream;
        return $this;
    }

    /**
     * @param string $data
     * @return Stream
     */
    abstract protected function doWrite($data);
}