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

/**
 * Base for stream based listeners
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class Stream implements Listener
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
    public function listen(Handler $handler)
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
     * @param Handler      $handler
     * @param Notification $notification
     */
    protected function handle(Handler $handler, Notification $notification)
    {
        try {
            $handler->handle($notification);
            $this->write("RESULT 2\nOK");
        } catch (EventHandlingFailed $e) {
            $this->write("RESULT 4\nFAIL");
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
        if ($header = $this->read()) {
            $header = $this->parseData($header);

            $payload = $this->read($header['len']);
            $payload = explode("\n", $payload, 2);
            isset($payload[1]) or $payload[1] = null;

            list($payload, $body) = $payload;

            $payload = $this->parseData($payload);

            return new Notification($header, $payload, $body);
        }
    }

    /**
     * Parses colon devided data
     *
     * @param string $rawData
     *
     * @return array
     */
    protected function parseData($rawData)
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
    abstract protected function read($length = null);

    /**
     * Writes data to output stream
     *
     * @param string $value
     */
    abstract protected function write($value);
}
