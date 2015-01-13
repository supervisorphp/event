<?php

namespace spec\Supervisor\Event\Handler;

use Supervisor\Event\Notification;
use Supervisor\Exception\EventHandlingFailed;
use PhpSpec\ObjectBehavior;

class CallbackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function() {});
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Supervisor\Event\Handler\Callback');
    }

    function it_is_a_handler()
    {
        $this->shouldImplement('Supervisor\Event\Handler');
    }

    function it_handles_a_notification(Notification $notification)
    {
        $this->handle($notification);
    }

    function it_throws_an_exception_when_handling_failed(Notification $notification)
    {
        $this->beConstructedWith(function() { throw new EventHandlingFailed; });
        $this->shouldThrow('Supervisor\Exception\EventHandlingFailed')->duringHandle($notification);
    }
}
