<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

interface LogLevelComparator
{
    /**
     * Compare two log levels
     *
     * @param $level_a
     * @param $level_b
     *
     * @return int
     */
    public function compare($level_a, $level_b) : int;
}