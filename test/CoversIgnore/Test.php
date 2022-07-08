<?php
namespace Test\CoversIgnore;

use PHPUnit\Framework\TestCase;
use TRegx\CoversIgnore\TestFile;
use function Test\resource\resource;

class Test extends TestCase
{
    /**
     * @test
     */
    public function testCoversInString(): void
    {
        // given
        $input = \file_get_contents(resource("php/identity.txt"));
        $case = new TestFile($input);
        // when, then
        $this->assertSame($input, $case->coversIgnored());
    }

    /**
     * @test
     * @dataProvider inputs
     */
    public function test(string $input, string $expected): void
    {
        // given
        $input = \file_get_contents(resource($input));
        $expected = \file_get_contents(resource($expected));
        // when
        $file = new TestFile($input);
        // then
        $this->assertSame($expected, $file->coversIgnored());
    }

    public function inputs(): array
    {
        return [
            ['php/covers/covers.txt', 'php/covers/expected.txt'],
            ['php/covers.x2/covers.txt', 'php/covers.x2/expected.txt'],
            ['php/coversNothing/coversNothing.txt', 'php/coversNothing/expected.txt'],
        ];
    }
}
