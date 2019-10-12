<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

use Calgamo\Util\Util;
use Psr\Log\LoggerTrait;
use Psr\Log\LoggerInterface;

class SimpleOutputLogger extends Stream implements LoggerInterface
{
    use LoggerTrait;

    /**
     * PhpMemoryLogger constructor.
     *
     * @param LogFormatterInterface $formatter
     * @param string $line_end
     */
    public function __construct(LogFormatterInterface $formatter = null, string $line_end = LineEnd::EOL)
    {
        parent::__construct('php://output', $formatter, $line_end);
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
