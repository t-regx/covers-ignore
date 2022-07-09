<?php
namespace Test\CoversIgnore;

use PHPUnit\Framework\TestCase;
use Test\Resources;
use TRegx\CoversIgnore\Application;
use function Test\output\output;
use function Test\resource\resource;

class ApplicationTest extends TestCase
{
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
        $app = new Application($this->resources->url());
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
    public function testDirectory(): void
    {
        // given
        $this->resources->use('root');
        $app = new Application($this->resources->url());

        // when
        $output = output(fn() => $app->run(['', 'directory']));

        // then
        $output->assertOutput([
            'File cleaned .\directory\child\covers.x2.php',
            'File cleaned .\directory\covers.php',
            'Checked: 2 files. Updated 2 files. 0 files were already clean.',
            ''
        ]);
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
}
