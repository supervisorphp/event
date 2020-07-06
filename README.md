# Supervisor Event

[![Latest Version](https://img.shields.io/github/release/supervisorphp/event.svg)](https://github.com/supervisorphp/event/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/supervisorphp/event.svg)](https://packagist.org/packages/supervisorphp/event)
[![Test Suite](https://github.com/supervisorphp/event/workflows/Test%20Suite/badge.svg)](https://github.com/supervisorphp/event/actions)

**Listen to Supervisor events in PHP.**


## Install

Via Composer

```bash
$ composer require supervisorphp/event
```

## Usage

Supervisor has this pretty good feature: notify you(r listener) about it's events.

The main entry point is the `Listener`. `Listeners`s wait for a `Handler` in the main listening logic. `Handler`s get a `Notification` when an event occurs.

```php
$handler = new \Supervisor\Event\Handler\CallbackHandler(function(\Supervisor\Event\Notification $notification) {
	echo $notification->getHeader('eventname');
});

$listener = new \Supervisor\Event\Listener\StandardListener;
$listener->listen($handler);
```

Currently available listeners:

- Standard: Listents to standard input stream, writes to standard output
- Guzzle: Uses `StreamInterface` to provide an easy interface for reading/writting

Additionally you can use two exceptions to control the listeners itself:

- `Supervisor\Exception\StopListenerException`: indicates that the `Listener` should stop listening for further events.
- `Supervisor\Exception\EventHandlingFailedException`: indicates that handling the event failed, `Listener` should return with a FAIL response.

Any other unhandled exceptions/errors will cause the listener to stop.

Check the Supervisor docs for more about [Events](http://supervisord.org/events.htm).

## Testing

```bash
phpspec run
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/supervisorphp/event/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
