<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Stk2k\StreamLogger\SimpleMemoryLogger;
use Stk2k\StreamLogger\Formatter\DefaultFormatter;

final class MemoryLoggerTest extends TestCase
{
    const TEST_LOG_FORMAT = '%DATE_Y4%/%DATE_M%/%DATE_D% %LEVEL%: %MESSAGE% %CONTEXT%';

    public function testLog()
    {
        $logger = new SimpleMemoryLogger();

        $logger->debug('Hello, world!');
        list($file, $line) = [ __FILE__, __LINE__ - 1 ];

        $lines = $logger->toArray();

        $context = json_encode([]);
        $expected_log1 = sprintf("%s [debug] Hello, world! %s      @%s(%s)", date('Y-m-d H:i:s'), $context, $file, $line);
        $expected = [$expected_log1];
        $this->assertSame($expected, $lines);


        $logger->warning('Something is wrong...', ['foo' => 'bar', 'cat' => 'tiger']);
        list($file, $line) = [ __FILE__, __LINE__ - 1 ];

        $lines = $logger->toArray();

        $context = json_encode(['foo' => 'bar', 'cat' => 'tiger']);
        $expected_log2 = sprintf('%s [warning] Something is wrong... %s      @%s(%s)', date('Y-m-d H:i:s'), $context, $file, $line);
        $expected = [$expected_log1, $expected_log2];
        $this->assertSame($expected, $lines);
    }

    public function testTruncate()
    {
        $logger = new SimpleMemoryLogger();

        $logger->debug('Hello, world!');

        $this->assertCount(1, $logger->toArray());

        $logger->truncate();

        $this->assertCount(0, $logger->toArray());

        $logger->debug('Hello, world!');
        $logger->warning('Something is wrong...', ['foo' => 'bar', 'cat' => 'tiger']);

        $this->assertCount(2, $logger->toArray());

        $logger->truncate();

        $this->assertCount(0, $logger->toArray());
    }

    public function testCustomFormat()
    {
        $logger = new SimpleMemoryLogger(new DefaultFormatter(self::TEST_LOG_FORMAT));

        $logger->debug('Hello, world!');

        $lines = $logger->toArray();

        $context = json_encode([]);
        $expected_log1 = sprintf("%s debug: Hello, world! %s", date('Y/m/d'), $context);
        $expected = [$expected_log1];
        $this->assertSame($expected, $lines);


        $logger->warning('Something is wrong...', ['foo' => 'bar', 'cat' => 'tiger']);

        $lines = $logger->toArray();

        $context = json_encode(['foo' => 'bar', 'cat' => 'tiger']);
        $expected_log2 = sprintf('%s warning: Something is wrong... %s', date('Y/m/d'), $context);
        $expected = [$expected_log1, $expected_log2];
        $this->assertSame($expected, $lines);
    }
}