<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\BufferedOutputLogger;

$logger = new BufferedOutputLogger();

$logger->debug('debug', [ 'a' => 'b', 'c' => 'd' ]);
$logger->warning('warning');
$logger->error('error', [ 'a' => 'b', 'c' => 'f' ]);
$logger->notice('notice', [ 'a' => 'c', 'c' => 'd' ]);
$logger->info('info', [ 'a' => null ]);
$logger->critical('critical', [ 'a' => 3.14 ]);

$logger->filterByContext([ 'c' => 'd' ])->flush();


