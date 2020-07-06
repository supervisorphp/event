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

/**
 * Accepts a callable
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CallbackHandler implements HandlerInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Notification $notification): void
    {
        call_user_func($this->callback, $notification);
    }
}
