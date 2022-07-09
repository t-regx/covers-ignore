<?php
namespace Test\CoversIgnore;

use PHPUnit\Framework\TestCase;
use Test\FileSystem;
use TRegx\CoversIgnore\Application;
use function Test\resource\resource;
use function Test\resource\resource_path;

class ApplicationTest extends TestCase
{
    private FileSystem $fileSystem;

    public function setUp(): void
    {
        $this->fileSystem = new FileSystem('root');
    }

    /**
     * @test
     */
    public function testDirectory(): void
    {
        // given
        $this->fileSystem->copy(resource_path('root'));

        // when
        $app = new Application($this->fileSystem->url());
        $app->run(['', 'directory']);

        // then
        $expected = [
            'root' => [
                'directory' => [
                    'child'      => [
                        'covers.x2.php' => resource('php/covers.x2/covers.x2.expected.txt'),
                    ],
                    'covers.php' => resource('php/covers/covers.expected.txt')
                ]
            ],
        ];
        $this->assertEquals($expected, $this->fileSystem->structure());
    }

    /**
     * @test
     */
    public function testFile(): void
    {
        // given
        $this->fileSystem->copy(resource_path('root'));

        // when
        $app = new Application($this->fileSystem->url());
        $app->run(['', 'directory/covers.php']);

        // then
        $expected = [
            'root' => [
                'directory' => [
                    'child'      => [
                        'covers.x2.php' => resource('php/covers.x2/covers.x2.txt'),
                    ],
                    'covers.php' => resource('php/covers/covers.expected.txt')
                ]
            ],
        ];
        $this->assertEquals($expected, $this->fileSystem->structure());
    }
}
