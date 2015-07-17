<?php

namespace AppBundle\Stream;

use SplFileInfo;

class FileStream extends AbstractStream
{
    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @param \SplFileObject $file
     */
    private function __construct(\SplFileObject $file)
    {
        $this->file = $file;
    }

    /**
     * @param string $filename
     * @return FileStream
     * @throws StreamNotWritebleException
     */
    public static function fromFilename($filename)
    {
        $file = new SplFileInfo($filename);
        return self::fromFileInfo($file);
    }

    /**
     * @param $file
     * @return FileStream
     * @throws StreamNotWritebleException
     */
    public static function fromFileInfo(SplFileInfo $file)
    {
        if (!$file->isWritable()) {
            throw new StreamNotWritebleException(sprintf('"%s" is not writable!'));
        }
        return new self($file->openFile('w'));
    }

    public static function fromResource($resource)
    {
        $file = new \SplFileObject();
    }

    /** @inheritdoc */
    protected function doWrite($data)
    {
        ;
    }
}