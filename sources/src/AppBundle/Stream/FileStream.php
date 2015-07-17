<?php

namespace AppBundle\Stream;

use AppBundle\Stream\Exception\StreamNotWritableException;
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
    public function __construct(\SplFileObject $file)
    {
        $this->file = $file;
    }

    /**
     * @param string $filename
     * @return FileStream
     * @throws StreamNotWritableException
     */
    public static function fromFilename($filename)
    {
        $file = new SplFileInfo($filename);
        return self::fromFileInfo($file);
    }

    /**
     * @param SplFileInfo $file
     * @return FileStream
     * @throws StreamNotWritableException
     */
    public static function fromFileInfo(SplFileInfo $file)
    {
        if (self::canWrite($file)) {
            throw new StreamNotWritableException(sprintf('"%s" is not writable!', $file->getFilename()));
        }
        return new self($file->openFile('w'));// (!f && d) || (f && w) = !((f || !d) && (!f || !w)) = !(())
    }

    private static function canWrite(SplFileInfo $file)
    {
        if (!$file->isFile() && (new SplFileInfo($file->getPath()))->isWritable()) {
            touch($file->getPathname());
            return true;
        }
        return false;
    }

    /** @inheritdoc */
    protected function doWrite($data)
    {
        $this->file->fwrite($data);
        return $this;
    }
}