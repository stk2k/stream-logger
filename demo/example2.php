<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\SimpleMemoryLogger;
use Stk2k\StreamLogger\Formatter\DefaultFormatter;

$logger = new SimpleMemoryLogger(new DefaultFormatter('%LEVEL%:%MESSAGE%'));
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

print_r($logger->toArray());
