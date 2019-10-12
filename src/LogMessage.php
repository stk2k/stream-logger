<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

final class LogMessage
{
    /** @var mixed */
    private $level;

    /** @var string */
    private $message;

    /** @var array */
    private $context;

    /** @var string */
    private $file;

    /** @var int */
    private $line;

    /** @var DateTime */
    private $time;

    /**
     * LogMessage constructor.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @param string $file
     * @param int $line
     * @param DateTime $time
     */
    public function __construct($level, string $message, array $context, string $file, int $line, DateTime $time)
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
        $this->file = $file;
        $this->line = $line;
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getContext() : array
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getFile() : string
    {
        return $this->file;
    }

    /**
     * @return int
     */
    public function getLine() : int
    {
        return $this->line;
    }

    /**
     * @return DateTime
     */
    public function getTime() : DateTime
    {
        return $this->time;
    }
}