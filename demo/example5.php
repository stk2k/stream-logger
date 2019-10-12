<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\SimpleMemoryLogger;

$logger = new SimpleMemoryLogger(PhpStream::OUTPUT);
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

$logger = new SimpleMemoryLogger(PhpStream::OUTPUT, null, "<br>\n");
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');


$logger = new SimpleMemoryLogger(PhpStream::STDERR);
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');
