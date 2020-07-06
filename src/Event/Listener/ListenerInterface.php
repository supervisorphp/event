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

/**
 * Listens to events
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface ListenerInterface
{
    /**
     * Starts listening for events
     *
     * @param HandlerInterface $handler
     */
    public function listen(HandlerInterface $handler): void;
}
