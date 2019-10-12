<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger\Comparator;

use Psr\Log\LogLevel;
use Stk2k\StreamLogger\LogLevelComparator;

final class PsrLogLevelComparator implements LogLevelComparator
{
    public function compare($level_a, $level_b): int
    {
        $priority_map = [
            LogLevel::EMERGENCY => 8,
            LogLevel::ALERT => 7,
            LogLevel::CRITICAL => 6,
            LogLevel::ERROR => 5,
            LogLevel::WARNING => 4,
            LogLevel::NOTICE => 3,
            LogLevel::INFO => 2,
            LogLevel::DEBUG => 1,
        ];

        $priority_a = $priority_map[$level_a] ?? 0;
        $priority_b = $priority_map[$level_b] ?? 0;

        return $priority_a - $priority_b;
    }
}
