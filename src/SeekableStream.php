<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

class SeekableStream extends Stream
{
    /**
     * Truncate logs
     */
    public function truncate()
    {
        $fp = $this->getFilePointer();
        ftruncate($fp, 0);
        fseek($fp, 0);
    }

    /**
     * Return log messages as array of string
     *
     * @return array
     */
    public function toArray(): array
    {
        $ret = [];
        $this->each(function ($line) use (&$ret) {
            $ret[] = $line;
        });

        return $ret;
    }

    /**
     * Callback all logs by line
     *
     * @param callable $callback
     */
    public function each(callable $callback)
    {
        $fp = $this->getFilePointer();
        fseek($fp, 0);

        $index = 0;
        while (1) {
            $line = fgets($fp);
            if ($line === false) {
                break;
            }
            $line = rtrim($line, $this->getLineEnd());

            ($callback)($line, $index);

            $index++;
        };

        fseek($fp, 0, SEEK_END);
    }

}