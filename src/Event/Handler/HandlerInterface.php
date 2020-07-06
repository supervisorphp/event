<?php

/*
 * This file is part of the Supervisor Event package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Supervisor\Event\Handler;

use Supervisor\Event\Notification;
use Supervisor\Exception\EventHandlingFailedException;
use Supervisor\Exception\StopListenerException;

/**
 * Handles Notifications
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface HandlerInterface
{
    /**
     * Handles a notification
     *
     * @param Notification $notification
     *
     * @throws EventHandlingFailedException If event handling fails
     * @throws StopListenerException        If listener should be stopped
     */
    public function handle(Notification $notification): void;
}
