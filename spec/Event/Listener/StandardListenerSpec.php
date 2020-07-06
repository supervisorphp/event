<?php

namespace spec\Supervisor\Event\Listener;

use PhpSpec\ObjectBehavior;
use Supervisor\Stub\HandlerInterface;
use Supervisor\Event\Listener\StandardListener;
use Supervisor\Event\Listener\ListenerInterface;

class StandardListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StandardListener::class);
    }

    function it_is_a_listener()
    {
        $this->shouldImplement(ListenerInterface::class);
    }

    function it_has_an_input_stream()
    {
        $this->getInputStream()
            ->shouldReturn(STDIN);
    }

    function it_has_an_output_stream()
    {
        $this->getOutputStream()
            ->shouldReturn(STDOUT);
    }

    function it_throws_an_exception_when_invalid_resource_passed()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['invalid_resource']);
    }

    function it_listens_to_events()
    {
        $handler = new HandlerInterface;
        $inputStream = fopen('php://temp', 'r+');
        $outputStream = fopen('php://temp', 'r+');

        fwrite($inputStream, "\n");
        fwrite($inputStream, "ver:3.0 server:supervisor serial:21 pool:listener poolserial:10 eventname:PROCESS_COMMUNICATION_STDOUT len:85\nprocessname:foo groupname:bar pid:123\nThis is the data that was sent between the tags");
        fwrite($inputStream, "ver:3.0 server:supervisor serial:21 pool:listener poolserial:10 eventname:PROCESS_COMMUNICATION_STDOUT len:85\nprocessname:foo groupname:bar pid:123\nThis is the data that was sent between the tags");
        fwrite($inputStream, "ver:3.0 server:supervisor serial:21 pool:listener poolserial:10 eventname:PROCESS_COMMUNICATION_STDOUT len:85\nprocessname:foo groupname:bar pid:123\nThis is the data that was sent between the tags");
        fseek($inputStream, 0);

        $this->beConstructedWith($inputStream, $outputStream);

        $this->listen($handler);
    }
}
