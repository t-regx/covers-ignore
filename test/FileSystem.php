<?php
namespace Test;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class FileSystem
{
    private vfsStreamDirectory $directory;

    public function __construct(string $directoryName)
    {
        $this->directory = vfsStream::setup($directoryName);
    }

    public function url(): string
    {
        return $this->directory->url();
    }

    public function copy(string $source): void
    {
        vfsStream::copyFromFileSystem($source, $this->directory);
    }

    public function structure(): array
    {
        return vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure();
    }
}
