<?php
namespace Test\CoversIgnore;

use PHPUnit\Framework\TestCase;
use function Test\resource\resource;
use function TRegx\Ignore\ignoredCovers;

class Test extends TestCase
{
    /**
     * @test
     */
    public function testCoversInString(): void
    {
        // given
        $input = \file_get_contents(resource("php/identity.txt"));
        // when
        $output = ignoredCovers($input);
        // then
        $this->assertSame($input, $output);
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
        $output = ignoredCovers($input);
        // then
        $this->assertSame($expected, $output);
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
