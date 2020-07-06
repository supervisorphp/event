<?php

/*
 * This file is part of the Supervisor Event package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Supervisor\Event;

/**
 * Contains information about the notification dispatched
 *
 * @link http://supervisord.org/events.html#event-listeners-and-event-notifications
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Notification
{
    /**
     * @var array
     */
    protected $header;

    /**
     * @var array
     */
    protected $payload;

    /**
     * @var string
     */
    protected $body;

    /**
     * @param array  $header
     * @param array  $payload
     * @param string $body
     */
    public function __construct(array $header, array $payload, $body = null)
    {
        $this->header = $header;
        $this->payload = $payload;
        $this->body = $body;
    }

    /**
     * Returns the event name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->header['eventname'] ?? null;
    }

    /**
     * Returns a specific header key
     *
     * @param string|null $key
     *
     * @return string|null|array
     */
    public function getHeader($key = null)
    {
        if (is_null($key)) {
            return $this->header;
        }

        return $this->header[$key] ?? null;
    }

    /**
     * Returns a specific key
     *
     * @param string|null $key
     *
     * @return string|null|array
     */
    public function getPayload($key = null)
    {
        if (is_null($key)) {
            return $this->payload;
        }

        return $this->payload[$key] ?? null;
    }

    /**
     * Returns the body
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
