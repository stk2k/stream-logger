<?php
require_once 'autoload.php';

use Stk2k\StreamLogger\BufferedOutputLogger;

$logger = new BufferedOutputLogger();
$logger->debug('Hello, world!');
$logger->warning('Something is wrong...');
