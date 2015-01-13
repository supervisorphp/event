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

use Supervisor\Exception\EventHandlingFailed;
use Supervisor\Exception\StopListener;

/**
 * Handles Notifications
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Handler
{
    /**
     * Handles a notification
     *
     * @param Notification $notification
     *
     * @throws EventHandlingFailed If event handling fails
     * @throws StopListener        If listener should be stopped
     */
    public function handle(Notification $notification);
}
