<?php

namespace spec\Supervisor\Event\Handler;

use PhpSpec\ObjectBehavior;
use Supervisor\Event\Notification;
use Supervisor\Exception\EventHandlingFailedException;
use Supervisor\Event\Handler\CallbackHandler;
use Supervisor\Event\Handler\HandlerInterface;

class CallbackHandlerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function() {});
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CallbackHandler::class);
    }

    function it_is_a_handler()
    {
        $this->shouldImplement(HandlerInterface::class);
    }

    function it_handles_a_notification(Notification $notification)
    {
        $this->handle($notification);
    }

    function it_throws_an_exception_when_handling_failed(Notification $notification)
    {
        $this->beConstructedWith(function() { throw new EventHandlingFailedException; });

        $this->shouldThrow(EventHandlingFailedException::class)
            ->duringHandle($notification);
    }
}
