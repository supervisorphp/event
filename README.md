# Supervisor Event

[![Latest Version](https://img.shields.io/github/release/supervisorphp/event.svg?style=flat-square)](https://github.com/supervisorphp/event/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/supervisorphp/event.svg?style=flat-square)](https://travis-ci.org/supervisorphp/event)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/supervisorphp/event.svg?style=flat-square)](https://scrutinizer-ci.com/g/supervisorphp/event)
[![Quality Score](https://img.shields.io/scrutinizer/g/supervisorphp/event.svg?style=flat-square)](https://scrutinizer-ci.com/g/supervisorphp/event)
[![HHVM Status](https://img.shields.io/hhvm/supervisorphp/event.svg?style=flat-square)](http://hhvm.h4cc.de/package/supervisorphp/event)
[![Total Downloads](https://img.shields.io/packagist/dt/supervisorphp/event.svg?style=flat-square)](https://packagist.org/packages/supervisorphp/event)
[![Dependency Status](https://img.shields.io/versioneye/d/php/supervisorphp:supervisor-event.svg?style=flat-square)](https://www.versioneye.com/php/supervisorphp:supervisor-event)

**Listen to Supervisor events in PHP.**


## Install

Via Composer

``` bash
$ composer require supervisorphp/event
```

## Usage

Supervisor has this pretty good feature: notify you(r listener) about it's events.

The main entry point is the `Listener`. `Listeners`s wait for a `Handler` in the main listening logic. `Handler`s get a `Notification` when an event occurs.


``` php
use Supervisor\Event\Listener\Standard;
use Supervisor\Event\Handler\Callback;
use Supervisor\Event\Notification;

$handler = new Callback(function(Notification $notification) {
	echo $notification->getHeader('eventname');
});

$listener = new Standard;

$listener->listen($handler);
```

Currently available listeners:

- Standard: Listents to standard input stream, writes to standard output
- Guzzle: Uses `StreamInterface` to provide an easy interface for reading/writting


Additionally you can use two exceptions to control the listeners itself:

- `Supervisor\Exception\StopListener`: indicates that the `Listener` should stop listening for further events.
- `Supervisor\Exception\EventHandlingFailed`: indicates that handling the event failed, `Listener` should return with a FAIL response.

Any other unhandled exceptions/errors will cause the listener to stop.


Check the Supervisor docs for more about [Events](http://supervisord.org/events.htm).


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/supervisorphp/event/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
