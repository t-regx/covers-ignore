<?php
namespace Test;

use Exception;
use PHPUnit\Framework\TestCase;
use TRegx\CoversIgnore\Arguments;

class ArgumentsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowForMissingArgument()
    {
        // given
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Usage: covers-ignore [file|directory/]');
        // when
        new Arguments(['filename']);
    }

    /**
     * @test
     */
    public function shouldThrowForSuperfluousArgument()
    {
        // given
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Usage: covers-ignore [file|directory/]');
        // when
        new Arguments(['filename', 'file', 'superfluous']);
    }
}
