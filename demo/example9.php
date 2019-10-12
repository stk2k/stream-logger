<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\BufferedOutputLogger;

$start = time();

$logger = new BufferedOutputLogger();

$logger->debug('debug');    sleep(1);
$logger->warning('warning');    sleep(1);
$logger->error('error');    sleep(1);
$logger->notice('notice');  sleep(1);
$logger->info('info');  sleep(1);
$logger->critical('critical');

$end = time();

echo 'start:' . date('y-m-d H:i:s', $start) . PHP_EOL;
echo 'end:' . date('y-m-d H:i:s', $end) . PHP_EOL;
$logger->filterByTimeBetween($start + 2, $start + 4)->flush();

