<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

use Stk2k\StreamLogger\Formatter\DefaultFormatter;

class Stream
{
    /** @var resource */
    private $fp;

    /** @var LogFormatterInterface */
    private $formatter;

    /** @var string */
    private $line_end;

    /**
     * Stream constructor.
     *
     * @param string $stream
     * @param LogFormatterInterface $formatter
     * @param string $line_end
     */
    public function __construct(string $stream, LogFormatterInterface $formatter = null, string $line_end = LineEnd::EOL)
    {
        $this->fp = fopen($stream, 'a+');
        $this->formatter = $formatter ?? new DefaultFormatter();
        $this->line_end = $line_end;
    }

    /**
     * Set log formatter
     *
     * @param LogFormatterInterface $formatter
     */
    public function setLogFormatter(LogFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Get line end
     *
     * @return string
     */
    public function getLineEnd() : string
    {
        return $this->line_end;
    }

    /**
     * Write line to stream
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @param string $file
     * @param int $line
     * @param DateTime $time
     */
    public function writeln($level, $message, $context, $file, $line, DateTime $time)
    {
        $line = $this->formatter->format($level, $message, $context, $file, $line, $time);

        fwrite($this->fp, $line . $this->line_end);
    }

    /**
     * Get file pointer
     *
     * @return false|resource
     */
    protected function getFilePointer()
    {
        return $this->fp;
    }
}