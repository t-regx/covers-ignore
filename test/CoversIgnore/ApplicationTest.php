<?php
namespace Test\CoversIgnore;

use PHPUnit\Framework\TestCase;
use Test\ArchitectureDependant;
use Test\Resources;
use Test\StateConsole;
use TRegx\CoversIgnore\Application;
use function Test\resource\resource;

class ApplicationTest extends TestCase
{
    use ArchitectureDependant;

    private Resources $resources;

    public function setUp(): void
    {
        $this->resources = new Resources('root');
    }

    /**
     * @test
     */
    public function testFile(): void
    {
        // given
        $this->resources->use('root');

        // when
        $app = new Application($this->resources->url(), new StateConsole());
        $app->run(['', 'directory/covers.php']);

        // then
        $this->resources->assertStructure([
            'root' => [
                'directory' => [
                    'child'      => [
                        'covers.x2.php' => resource('php/covers.x2/covers.x2.txt'),
                    ],
                    'covers.php' => resource('php/covers/covers.expected.txt')
                ]
            ],
        ]);
    }

    /**
     * @test
     */
    public function testDirectoryCleans(): void
    {
        // given
        $this->resources->use('root');
        $app = new Application($this->resources->url(), new StateConsole());
        // when
        $app->run(['', 'directory']);
        // then
        $this->resources->assertStructure([
            'root' => [
                'directory' => [
                    'child'      => [
                        'covers.x2.php' => resource('php/covers.x2/covers.x2.expected.txt'),
                    ],
                    'covers.php' => resource('php/covers/covers.expected.txt')
                ]
            ],
        ]);
    }

    /**
     * @test
     */
    public function testDirectorySummaryWindows(): void
    {
        $this->marTestUnnecessaryOnUnix();
        // given
        $this->resources->use('root');
        $console = new StateConsole();
        $app = new Application($this->resources->url(), $console);
        // when
        $app->run(['', 'directory']);
        // then
        $this->assertEquals(2, $console->statistics()->updated);
        $this->assertEquals(2, $console->statistics()->all);
        $expected = [
            '.\directory\child\covers.x2.php',
            '.\directory\covers.php',
        ];
        $this->assertSame($expected, $console->filenamesInOrder());
    }

    /**
     * @test
     */
    public function testDirectorySummaryUnix(): void
    {
        $this->markTestUnnecessaryOnWindows();
        // given
        $this->resources->use('root');
        $console = new StateConsole();
        $app = new Application($this->resources->url(), $console);
        // when
        $app->run(['', 'directory']);
        // then
        $this->assertEquals(2, $console->statistics()->updated);
        $this->assertEquals(2, $console->statistics()->all);
        $expected = [
            './directory/child/covers.x2.php',
            './directory/covers.php',
        ];
        $this->assertSame($expected, $console->filenamesInOrder());
    }
}
