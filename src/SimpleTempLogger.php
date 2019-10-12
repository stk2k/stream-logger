<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

use Calgamo\Util\Util;
use Psr\Log\LoggerTrait;
use Psr\Log\LoggerInterface;

class SimpleTempLogger extends Stream implements LoggerInterface
{
    use LoggerTrait;

    /**
     * PhpMemoryLogger constructor.
     *
     * @param int $max_memory
     * @param LogFormatterInterface $formatter
     * @param string $line_end
     */
    public function __construct(int $max_memory = null, LogFormatterInterface $formatter = null, string $line_end = LineEnd::EOL)
    {
        parent::__construct($max_memory ? "php://temp/maxmemory:{$max_memory}" : 'php://temp', $formatter, $line_end);
    }

    /**
     * {@inheritDoc}
     */
    public function log($level, $message, array $context = array())
    {
        list($file, $line) = Util::caller(2);

        $this->writeln($level, $message, $context, $file, $line, new DateTime());
    }
}
