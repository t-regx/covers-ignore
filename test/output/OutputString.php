<?php
namespace Test\output;

use PHPUnit\Framework\Assert;

class OutputString
{
    private string $output;

    public function __construct(string $output)
    {
        $this->output = $output;
    }

    public function assertOutput(array $lines): void
    {
        Assert::assertSame(\join(\PHP_EOL, $lines), $this->output);
    }
}
