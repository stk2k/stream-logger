<?php
require_once __DIR__ . '/include/autoload.php';
require_once __DIR__ . '/include/file1.php';
require_once __DIR__ . '/include/file2.php';

$logger->debug('debug');
$logger->warning('warning');
$logger->error('error');
$logger->notice('notice');
$logger->info('info');
$logger->critical('critical');

$logger->filterByFilename('7')->flush();

