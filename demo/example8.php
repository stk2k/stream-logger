<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\BufferedOutputLogger;

$logger = new BufferedOutputLogger();

$logger->debug('debug');
$logger->warning('warning');
$logger->error('error');
$logger->notice('notice');
$logger->info('info');
$logger->critical('critical');

$logger->filterByLineBetween(9, 10)->flush();

