<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

interface LogFormatterInterface
{
    /**
     * Format log message
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @param string $file
     * @param int $line
     * @param DateTime $time
     *
     * @return string
     */
    public function format($level, $message, array $context, string $file, int $line, DateTime $time) : string;
}