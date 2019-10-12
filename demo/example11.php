<?php
require_once __DIR__ . '/include/autoload.php';

use Psr\Log\LogLevel;
use Stk2k\StreamLogger\BufferedOutputLogger;
use Stk2k\StreamLogger\LogMessage;

$logger = new BufferedOutputLogger();

$logger->debug('debug');
$logger->warning('warning');
$logger->error('error');
$logger->notice('notice');
$logger->info('info');
$logger->critical('critical');

$logger->filter(function(LogMessage $m){
    return $m->getLevel() === LogLevel::INFO || $m->getLevel() === LogLevel::WARNING;
})->flush();

