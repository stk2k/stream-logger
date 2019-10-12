<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;
use Stk2k\StreamLogger\Comparator\PsrLogLevelComparator;

trait BufferedStreamTrait
{
    /** @var LogMessage[] */
    private $buffer;

    /**
     * Get stream
     *
     * @return Stream
     */
    abstract public function getStream() : Stream;

    /**
     * Add message
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @param string $file
     * @param int $line
     * @param DateTime $time
     */
    private function addMessage($level, string $message, array $context, string $file, int $line, DateTime $time)
    {
        $this->buffer[] = new LogMessage($level, $message, $context, $file, $line, $time);
    }

    /**
     * Flush buffer
     */
    public function flush() : self
    {
        $stream = $this->getStream();
        foreach($this->buffer as $m)
        {
            $stream->writeln($m->getLevel(), $m->getMessage(), $m->getContext(), $m->getFile(), $m->getLine(), $m->getTime());
        }
        $this->buffer = [];
        return $this;
    }

    /**
     * Filter buffer
     *
     * @param callable $filter
     *
     * @return $this
     */
    public function filter(callable $filter) : self
    {
        $this->buffer = array_filter($this->buffer, $filter);

        return $this;
    }

    /**
     * Filter buffer by log level
     *
     * @param mixed $level
     *
     * @return $this
     */
    public function filterByLevel($level) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($level){
            return $msg->getLevel() === $level;
        });

        return $this;
    }

    /**
     * Filter buffer by log levels
     *
     * @param array $levels
     *
     * @return $this
     */
    public function filterByLevels(array $levels) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($levels){
            return in_array($msg->getLevel(), $levels);
        });

        return $this;
    }

    /**
     * Filter buffer by minimum log level
     *
     * @param mixed $min_level
     * @param LogLevelComparator $comparator
     *
     * @return $this
     */
    public function filterByMinLevel($min_level, LogLevelComparator $comparator = null) : self
    {
        if (!$comparator){
            $comparator = new PsrLogLevelComparator();
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_level, $comparator){
            return $comparator->compare($msg->getLevel(), $min_level) >= 0;
        });

        return $this;
    }

    /**
     * Filter buffer by maximum log level
     *
     * @param mixed $max_level
     * @param LogLevelComparator $comparator
     *
     * @return $this
     */
    public function filterByMaxLevel($max_level, LogLevelComparator $comparator = null) : self
    {
        if (!$comparator){
            $comparator = new PsrLogLevelComparator();
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($max_level, $comparator){
            return $comparator->compare($msg->getLevel(), $max_level) <= 0;
        });

        return $this;
    }

    /**
     * Filter buffer by log level range
     *
     * @param mixed $min_level
     * @param mixed $max_level
     * @param LogLevelComparator $comparator
     *
     * @return $this
     */
    public function filterByLevelBetween($min_level, $max_level, LogLevelComparator $comparator = null) : self
    {
        if (!$comparator){
            $comparator = new PsrLogLevelComparator();
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_level, $max_level, $comparator){
            $lvl = $msg->getLevel();
            return $comparator->compare($lvl, $min_level) >= 0 && $comparator->compare($lvl, $max_level) <= 0;
        });

        return $this;
    }

    /**
     * Filter buffer by log message
     *
     * @param string $message
     *
     * @return $this
     */
    public function filterByMessage(string $message) : self
    {
        $regex = "/{$message}/";
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($regex){
            return preg_match($regex, $msg->getMessage());
        });

        return $this;
    }

    /**
     * Filter buffer by log message
     *
     * @param string $regex
     *
     * @return $this
     */
    public function filterByMessageRegEx(string $regex) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($regex){
            return preg_match($regex, $msg->getMessage());
        });

        return $this;
    }

    /**
     * Filter buffer by file name
     *
     * @param string $filename
     *
     * @return $this
     */
    public function filterByFilename(string $filename) : self
    {
        $regex = "/{$filename}/";
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($regex){
            return preg_match($regex, $msg->getFile());
        });

        return $this;
    }

    /**
     * Filter buffer by file name
     *
     * @param string $regex
     *
     * @return $this
     */
    public function filterByFilenameRegEx(string $regex) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($regex){
            return preg_match($regex, $msg->getFile());
        });

        return $this;
    }

    /**
     * Filter buffer by line number
     *
     * @param int $line
     *
     * @return $this
     */
    public function filterByLine(int $line) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($line){
            return $msg->getLine() === $line;
        });

        return $this;
    }

    /**
     * Filter buffer by minimum line number
     *
     * @param int $min_line
     *
     * @return $this
     */
    public function filterByMinLine(int $min_line) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_line){
            return $msg->getLine() >= $min_line;
        });

        return $this;
    }

    /**
     * Filter buffer by minimum line number
     *
     * @param int $max_line
     *
     * @return $this
     */
    public function filterByMaxLine(int $max_line) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($max_line){
            return $msg->getLine() <= $max_line;
        });

        return $this;
    }

    /**
     * Filter buffer by line number range
     *
     * @param int $min_line
     * @param int $max_line
     *
     * @return $this
     */
    public function filterByLineBetween(int $min_line, int $max_line) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_line, $max_line){
            return $msg->getLine() >= $min_line && $msg->getLine() <= $max_line;
        });

        return $this;
    }

    /**
     * Filter buffer by minimum date
     *
     * @param int|string $min_time
     *
     * @return $this
     */
    public function filterByMinTime($min_time) : self
    {
        if (is_string($min_time)){
            $min_time = strtotime($min_time);
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_time){
            return $msg->getTime()->getTimestamp() >= $min_time;
        });

        return $this;
    }

    /**
     * Filter buffer by maximum date
     *
     * @param int|string $max_time
     *
     * @return $this
     */
    public function filterByMaxTime($max_time) : self
    {
        if (is_string($max_time)){
            $max_time = strtotime($max_time);
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($max_time){
            return $msg->getTime()->getTimestamp() <= $max_time;
        });

        return $this;
    }

    /**
     * Filter buffer by date range
     *
     * @param int|string $min_time
     * @param int|string $max_time
     *
     * @return $this
     */
    public function filterByTimeBetween($min_time, $max_time) : self
    {
        if (is_string($min_time)){
            $min_time = strtotime($min_time);
        }
        if (is_string($max_time)){
            $max_time = strtotime($max_time);
        }
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($min_time, $max_time){
            $time = $msg->getTime()->getTimestamp();
            return $time >= $min_time && $time <= $max_time;
        });

        return $this;
    }

    /**
     * Filter buffer by date range
     *
     * @param array $context
     *
     * @return $this
     */
    public function filterByContext(array $context) : self
    {
        $this->buffer = array_filter($this->buffer, function(LogMessage $msg) use($context){
            $item_context = $msg->getContext();
            foreach($context as $key => $value){
                if (!isset($item_context[$key])){
                    return false;
                }
                $item_value = $item_context[$key];
                if ($item_value !== $value){
                    return false;
                }
            }
            return true;
        });

        return $this;
    }
}