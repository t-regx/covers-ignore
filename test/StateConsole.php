<?php
namespace Test;

use TRegx\CoversIgnore\Console;
use TRegx\CoversIgnore\Statistic;

class StateConsole extends Console
{
    private ?Statistic $statistic;
    private array $filenames;

    public function notify(string $filename): void
    {
        $this->filenames[] = $filename;
    }

    public function summary(Statistic $statistic): void
    {
        $this->statistic = $statistic;
    }

    public function filenamesInOrder(): array
    {
        $filenames = $this->filenames;
        \sort($filenames);
        return $filenames;
    }

    public function statistics(): Statistic
    {
        return $this->statistic;
    }
}
