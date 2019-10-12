<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\SimpleMemoryLogger;

$logger = new SimpleMemoryLogger();
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');

$logger->each(function($line){
    echo $line . PHP_EOL;
});

