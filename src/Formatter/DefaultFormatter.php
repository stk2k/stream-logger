<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger\Formatter;

use DateTime;

use Calgamo\Util\MacroProcessor;
use Stk2k\StreamLogger\LogFormatterInterface;

final class DefaultFormatter implements LogFormatterInterface
{
    const DEFAULT_LOG_FORMAT = '%DATE_Y4%-%DATE_M%-%DATE_D% %DATE_H24%:%DATE_I%:%DATE_S% [%LEVEL%] %MESSAGE% %CONTEXT%      @%FILENAME%(%LINE%)';

    /** @var string */
    private $format;

    /** @var MacroProcessor */
    private $processor;

    /**
     * DefaultFormatter constructor.
     *
     * @param string $format
     */
    public function __construct(string $format = self::DEFAULT_LOG_FORMAT)
    {
        $this->format = $format;
        $this->processor = new MacroProcessor();
    }

    /**
     * {@inheritDoc}
     *
     * @throws
     */
    public function format($level, $message, array $context, string $file, int $line, DateTime $time): string
    {
        return $this->processor->process($this->format, function($keyword) use($level, $message, $context, $file, $line, $time){
            switch($keyword){
                case 'LEVEL':
                    return $level;

                case 'MESSAGE':
                    return $message;

                case 'CONTEXT':
                    return json_encode($context);

                case 'FILENAME':
                    return $file;

                case 'LINE':
                    return $line;

                case 'DATE_Y4':
                case 'DATE_YEAR':
                    return $time->format('Y');

                case 'DATE_Y2':
                    return $time->format('y');

                case 'DATE_M':
                case 'DATE_MONTH':
                    return $time->format('m');

                case 'DATE_N':
                    return $time->format('n');

                case 'DATE_D':
                case 'DATE_DAY':
                    return $time->format('d');

                case 'DATE_J':
                    return $time->format('j');

                case 'DATE_H24':
                case 'DATE_HOUR':
                    return $time->format('H');

                case 'DATE_H12':
                    return $time->format('h');

                case 'DATE_I':
                case 'DATE_MINUTE':
                    return $time->format('i');

                case 'DATE_S':
                case 'DATE_SECOND':
                    return $time->format('s');
            }
            return false;
        });
    }
}