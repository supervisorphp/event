<?php

/*
 * This file is part of the Supervisor Event package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Supervisor\Event\Listener;

/**
 * Listener for standard IO streams
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class StandardListener extends AbstractStreamListener
{
    /**
     * @var resource
     */
    protected $inputStream = STDIN;

    /**
     * @var resource
     */
    protected $outputStream = STDOUT;

    /**
     * @param resource $inputStream
     * @param resource $outputStream
     */
    public function __construct($inputStream = STDIN, $outputStream = STDOUT)
    {
        $this->assertValidStreamResource($inputStream);
        $this->assertValidStreamResource($outputStream);

        $this->inputStream = $inputStream;
        $this->outputStream = $outputStream;
    }

    /**
     * Returns the input stream
     *
     * @return resource
     */
    public function getInputStream()
    {
        return $this->inputStream;
    }

    /**
     * Returns the output stream
     *
     * @return resource
     */
    public function getOutputStream()
    {
        return $this->outputStream;
    }

    /**
     * Asserts that a given input is a valid stream resource
     *
     * @param resource $stream
     *
     * @throws \InvalidArgumentException If $stream is not a valid resource
     */
    private function assertValidStreamResource($stream)
    {
        if (!is_resource($stream)) {
            throw new \InvalidArgumentException('Invalid resource for IO stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function read($length = null): string
    {
        if (is_null($length)) {
            return trim(fgets($this->inputStream));
        }

        return fread($this->inputStream, $length);
    }

    /**
     * {@inheritdoc}
     */
    protected function write($value)
    {
        return @fwrite($this->outputStream, $value);
    }
}
