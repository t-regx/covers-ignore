<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use TRegx\CoversIgnore\Console;
use TRegx\CoversIgnore\Statistic;
use function Test\output\output;

class ConsoleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldPrintSummary()
    {
        // given
        $console = new Console();
        // when
        $output = output(fn() => $console->summary($this->statistic()));
        // then
        $output->assertOutput([
            'Checked: 3 files. Updated 2 files. 1 files were already clean.',
            ''
        ]);
    }

    /**
     * @test
     */
    public function shouldPrintNotify()
    {
        // given
        $console = new Console();
        // when
        $output = output(fn() => $console->notify('filename.php'));
        // then
        $output->assertOutput([
            'File cleaned filename.php',
            ''
        ]);
    }

    private function statistic(): Statistic
    {
        $statistic = new Statistic();
        $statistic->nextFile();
        $statistic->nextFile();
        $statistic->nextFile();
        $statistic->nextFileUpdated();
        $statistic->nextFileUpdated();
        return $statistic;
    }
}
