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

use Indigo\Supervisor\Event\Listener;
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
class Stream implements Listener
{
    use RawDataParser;

    /**
     * @var StreamInterface
     */
    protected $inputStream;

    /**
     * @var StreamInterface
     */
    protected $outputStream;

    /**
     * Listener state: listen to events or not
     *
     * @var boolean
     */
    protected $listen = true;

    /**
     * @param EmitterInterface $emitter
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
    public function listen(Handler $handler)
    {
        while ($this->listen) {
            $this->outputStream->write("READY\n");

            if ($notification = $this->getNotification()) {
                $this->handle($handler, $notification);
            }
        }
    }

    /**
     * Handles the notification
     *
     * @param Handler      $handler
     * @param Notification $notification
     */
    protected function handle(Handler $handler, Notification $notification)
    {
        try {
            $handler->handle($notification);
            $this->outputStream->write("RESULT 2\nOK");
        } catch (EventHandlingFailed $e) {
            $this->outputStream->write("RESULT 4\nFAIL");
        } catch (StopListener $e) {
            $this->listen = false;
        }
    }

    /**
     * Returns notification from input stream if available
     *
     * @return Notification
     */
    protected function getNotification()
    {
        if ($header = trim(Utils::readLine($this->inputStream))) {
            $header = $this->parseData($header);

            $payload = $this->inputStream->read((int) $header['len']);
            $payload = explode("\n", $payload, 2);
            isset($payload[1]) or $payload[1] = null;

            list($payload, $body) = $payload;

            $payload = $this->parseData($payload);

            return new Notification($header, $payload, $body);
        }
    }
}
