<?php
namespace Test\CoversIgnore\Code;

use PHPUnit\Framework\TestCase;
use TRegx\CoversIgnore\Code\TestFile;
use function Test\resource\resource_file;
use function Test\resource\resource;

class TestFileTest extends TestCase
{
    /**
     * @test
     */
    public function testCoversInString(): void
    {
        // given
        $testFile = new TestFile(resource_file('php/covers.string.txt'));
        // when, then
        $this->assertSame(resource('php/covers.string.txt'), $testFile->coversIgnored());
    }

    /**
     * @test
     * @dataProvider inputs
     */
    public function test(string $input, string $expected): void
    {
        // given
        $expected = resource($expected);
        // when
        $testFile = new TestFile(resource_file($input));
        // then
        $this->assertSame($expected, $testFile->coversIgnored());
        $this->assertSame($expected, $testFile->coversIgnored());
    }

    public function inputs(): array
    {
        return [
            [
                'php/covers/covers.txt',
                'php/covers/covers.expected.txt'
            ],
            [
                'php/covers.x2/covers.x2.txt',
                'php/covers.x2/covers.x2.expected.txt'
            ],
            [
                'php/coversNothing/coversNothing.txt',
                'php/coversNothing/coversNothing.expected.txt'
            ],
        ];
    }

    /**
     * @test
     */
    public function shouldBeDirty(): void
    {
        // given
        $testFile = new TestFile(resource_file('php/covers/covers.txt'));
        // when, then
        $this->assertTrue($testFile->hasCovers());
        $this->assertTrue($testFile->hasCovers());
    }

    /**
     * @test
     */
    public function shouldNotBeDirty(): void
    {
        // given
        $testFile = new TestFile(resource_file('php/example.txt'));
        // when, then
        $this->assertFalse($testFile->hasCovers());
        $this->assertFalse($testFile->hasCovers());
    }

    /**
     * @test
     * @depends shouldNotBeDirty
     */
    public function shouldNotBeDirty_coversString(): void
    {
        // given
        $testFile = new TestFile(resource_file('php/covers.string.txt'));
        // when, then
        $this->assertFalse($testFile->hasCovers());
        $this->assertFalse($testFile->hasCovers());
    }
}
