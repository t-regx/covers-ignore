<?php
namespace Test;

use PHPUnit\Framework\Assert;
use function Test\resource\resource_path;

class Resources
{
    private FileSystem $fileSystem;

    public function __construct(string $directoryName)
    {
        $this->fileSystem = new FileSystem($directoryName);
    }

    public function use(string $directoryName): void
    {
        $this->fileSystem->copy(resource_path($directoryName));
    }

    public function url(): string
    {
        return $this->fileSystem->url();
    }

    public function assertStructure(array $expected): void
    {
        Assert::assertEquals($expected, $this->fileSystem->structure());
    }
}
