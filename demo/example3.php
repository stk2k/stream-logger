<?php
require_once __DIR__ . '/include/autoload.php';

use Stk2k\StreamLogger\SimpleMemoryLogger;
use Stk2k\StreamLogger\LogFormatterInterface;

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
