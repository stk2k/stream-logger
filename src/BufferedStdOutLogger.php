<?php
declare(strict_types=1);

namespace Stk2k\StreamLogger;

use DateTime;

use Calgamo\Util\Util;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class BufferedStdOutLogger extends SimpleStdOutLogger implements LoggerInterface
{
    use BufferedStreamTrait;
    use LoggerTrait;

    /**
     * {@inheritDoc}
     */
    public function log($level, $message, array $context = array())
    {
        list($file, $line) = Util::caller(2);

        $this->addMessage($level, $message,  $context, $file, $line, new DateTime());
    }

    /**
     * @return $this
     */
    public function getStream()
    {
        return $this;
    }

}