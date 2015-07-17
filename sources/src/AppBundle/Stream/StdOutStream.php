<?php

namespace AppBundle\Stream;

use Symfony\Component\Console\Output\OutputInterface;

class StdOutStream extends AbstractStream
{
    /**
     * @var OutputInterface
     */
    private $out;

    public function __construct(OutputInterface $out)
    {
        $this->out = $out;
    }

    /** @inheritdoc */
    protected function doWrite($data)
    {
        $this->out->write($data);
        return $this;
    }
}