PSR-3 logger compliant stream logger
=======================

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stk2k/stream-logger.svg?style=flat-square)](https://packagist.org/packages/stk2k/stream-logger)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/stk2k/stream-logger.svg?branch=master)](https://travis-ci.org/stk2k/stream-logger)
[![Coverage Status](https://coveralls.io/repos/github/stk2k/stream-logger/badge.svg?branch=master)](https://coveralls.io/github/stk2k/stream-logger?branch=master)
[![Code Climate](https://codeclimate.com/github/stk2k/stream-logger/badges/gpa.svg)](https://codeclimate.com/github/stk2k/stream-logger)
[![Total Downloads](https://img.shields.io/packagist/dt/stk2k/stream-logger.svg?style=flat-square)](https://packagist.org/packages/stk2k/stream-logger)

## Description

PSR-3 logger compliant stream logger

## Feature

- [PSR/Log](https://github.com/php-fig/log) compliant.
- PHP output streams
    - php://stdout
    - php://stderr
    - php://output
    - php://memory
    - php://temp
- Default formatter
- Custom format with default formatter
- Custom formatter class
- toArray()/each() method to get all log messages(only for MemoryLogger).
- filter methods for buffered stream loggers.

## Usage

### Default format

```php
use Stk2k\MemoryLogger\SimpleMemoryLogger;

$logger = new SimpleMemoryLogger();
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

print_r($logger->toArray());
// Array
// (
//     [0] => 2019-10-11 20:42:10 [debug] Hello, world! []      @...\example1.php(7)
//     [1] => 2019-10-11 20:42:10 [warning] Something is wrong... []      @...\example1.php(8)
// )
```

### Custom format with default formatter

```php
use Stk2k\MemoryLogger\SimpleMemoryLogger;
use Stk2k\MemoryLogger\Formatter\DefaultFormatter;

$logger = new SimpleMemoryLogger(new DefaultFormatter('%LEVEL%:%MESSAGE%'));
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

print_r($logger->toArray());
// Array
// (
//     [0] => debug:Hello, world!
//     [1] => warning:Something is wrong...
// )
```

### Custom formatter class

You can also define your own formatter by implementing LogFormatterInterface.

```php
use Stk2k\MemoryLogger\SimpleMemoryLogger;
use Stk2k\MemoryLogger\LogFormatterInterface;

class JsonFormatter implements LogFormatterInterface
{
    public function format($level, $message, array $context, string $file, int $line): string
    {
        return json_encode([
            'level' => $level, 'message' => $message, 'context' => $context, 'file' => $file, 'line' => $line,
        ]);
    }
}

$logger = new SimpleMemoryLogger(new JsonFormatter);
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

print_r($logger->toArray());
// Array
// (
//    [0] => {"level":"debug","message":"Hello, world!","context":[],"file":".../example3.php","line":18}
//    [1] => {"level":"warning","message":"Something is wrong...","context":[],"file":".../example3.php","line":19}
// )
```

### Retrieving each lines

```php
use Stk2k\MemoryLogger\SimpleMemoryLogger;

$logger = new SimpleMemoryLogger();
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

$logger->each(function($line){
    echo $line . PHP_EOL;
});
// 2019-10-11 20:58:33 [debug] Hello, world! []      @.../example4.php(7)
// 2019-10-11 20:58:33 [warning] Something is wrong... []      @.../example4.php(8)
```

### Filtering by log level

```php
use Stk2k\StreamLogger\BufferedOutputLogger;
use Psr\Log\LogLevel;

$logger = new BufferedOutputLogger();

$logger->debug('debug');
$logger->warning('warning');
$logger->error('error');
$logger->notice('notice');
$logger->info('info');
$logger->critical('critical');

$logger->filterByLevelBetween(LogLevel::WARNING, LogLevel::ERROR)->flush();
// 2019-10-12 10:46:29 [warning] warning []      @.../xample6.php(10)
// 2019-10-12 10:46:29 [error] error []      @.../example6.php(11)
```


## Requirement

PHP 7.0 or later

## Installing stk2k/stream-logger

The recommended way to install stk2k/stream-logger is through
[Composer](http://getcomposer.org).

```bash
composer require stk2k/stream-logger
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## License
This library is licensed under the MIT license.

## Author

[stk2k](https://github.com/stk2k)

## Disclaimer

This software is no warranty.

We are not responsible for any results caused by the use of this software.

Please use the responsibility of the your self.


