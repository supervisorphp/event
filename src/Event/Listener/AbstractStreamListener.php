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

use Supervisor\Event\Handler\HandlerInterface;
use Supervisor\Event\Notification;
use Supervisor\Exception\EventHandlingFailedException;
use Supervisor\Exception\StopListenerException;

/**
 * Base for stream based listeners
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class AbstractStreamListener implements ListenerInterface
{
    /**
     * Listener state: listen to events or not
     *
     * @var boolean
     */
    protected $listen = true;

    /**
     * {@inheritdoc}
     */
    public function listen(HandlerInterface $handler): void
    {
        while ($this->listen) {
            $this->write("READY\n");

            if ($notification = $this->getNotification()) {
                $this->handle($handler, $notification);
            }
        }
    }

    /**
     * Handles the notification
     *
     * @param HandlerInterface      $handler
     * @param Notification $notification
     */
    protected function handle(HandlerInterface $handler, Notification $notification): void
    {
        try {
            $handler->handle($notification);
            $this->write("RESULT 2\nOK");
        } catch (EventHandlingFailedException $e) {
            $this->write("RESULT 4\nFAIL");
        } catch (StopListenerException $e) {
            $this->listen = false;
        }
    }

    /**
     * Returns notification from input stream if available
     *
     * @return Notification|null
     */
    protected function getNotification(): ?Notification
    {
        if ($header = $this->read()) {
            $header = $this->parseData($header);

            $payload = $this->read($header['len']);
            $payload = explode("\n", $payload, 2);
            isset($payload[1]) or $payload[1] = null;

            [$payload, $body] = $payload;

            $payload = $this->parseData($payload);

            return new Notification($header, $payload, $body);
        }

        return null;
    }

    /**
     * Parses colon devided data
     *
     * @param string $rawData
     *
     * @return array
     */
    protected function parseData($rawData): array
    {
        $outputData = [];

        foreach (explode(' ', $rawData) as $data) {
            $data = explode(':', $data);
            $outputData[$data[0]] = $data[1];
        }

        return $outputData;
    }

    /**
     * Reads data from input stream
     *
     * @param integer $length If given read this size of bytes, read a line anyway
     *
     * @return string
     */
    abstract protected function read($length = null): string;

    /**
     * Writes data to output stream
     *
     * @param string $value
     *
     * @return int|string
     */
    abstract protected function write($value);
}
