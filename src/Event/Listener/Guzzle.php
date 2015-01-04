<?php

/*
 * This file is part of the Indigo Supervisor package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Supervisor\Event\Listener;

use Indigo\Supervisor\Event\Handler;
use Indigo\Supervisor\Event\Notification;
use Indigo\Supervisor\Exception\EventHandlingFailed;
use Indigo\Supervisor\Exception\StopListener;
use GuzzleHttp\Stream\StreamInterface;
use GuzzleHttp\Stream\Utils;

/**
 * Listener using guzzle streams
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Guzzle extends Stream
{
    /**
     * @var StreamInterface
     */
    protected $inputStream;

    /**
     * @var StreamInterface
     */
    protected $outputStream;

    /**
     * @param StreamInterface $inputStream
     * @param StreamInterface $outputStream
     */
    public function __construct(StreamInterface $inputStream, StreamInterface $outputStream)
    {
        $this->inputStream = $inputStream;
        $this->outputStream = $outputStream;
    }

    /**
     * Returns the input stream
     *
     * @return StreamInterface
     */
    public function getInputStream()
    {
        return $this->inputStream;
    }

    /**
     * Returns the output stream
     *
     * @return StreamInterface
     */
    public function getOutputStream()
    {
        return $this->outputStream;
    }

    /**
     * {@inheritdoc}
     */
    protected function read($length = null)
    {
        if (is_null($length)) {
            return trim(Utils::readLine($this->inputStream));
        }

        return $this->inputStream->read($length);
    }

    /**
     * {@inheritdoc}
     */
    protected function write($value)
    {
        return $this->outputStream->write($value);
    }
}
