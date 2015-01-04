<?php

namespace spec\Indigo\Supervisor\Event\Handler;

use Indigo\Supervisor\Event\Notification;
use Indigo\Supervisor\Exception\EventHandlingFailed;
use PhpSpec\ObjectBehavior;

class CallbackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function() {});
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Supervisor\Event\Handler\Callback');
    }

    function it_is_a_handler()
    {
        $this->shouldImplement('Indigo\Supervisor\Event\Handler');
    }

    function it_handles_a_notification(Notification $notification)
    {
        $this->handle($notification);
    }

    function it_throws_an_exception_when_handling_failed(Notification $notification)
    {
        $this->beConstructedWith(function() { throw new EventHandlingFailed; });
        $this->shouldThrow('Indigo\Supervisor\Exception\EventHandlingFailed')->duringHandle($notification);
    }
}
