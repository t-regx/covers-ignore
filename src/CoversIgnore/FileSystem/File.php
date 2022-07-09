<?php
namespace TRegx\CoversIgnore\FileSystem;

class File
{
    public function __construct(private string $filename)
    {
    }

    public function content(): string
    {
        return \file_get_contents($this->filename);
    }

    public function write(string $content): void
    {
        \file_put_contents($this->filename, $content);
    }

    public function relativePath(string $parent): string
    {
        if (\strPos($this->filename, $parent) === 0) {
            return '.' . \subStr($this->filename, \strLen($parent));
        }
        // @codeCoverageIgnoreStart
        throw new \Exception();
        // @codeCoverageIgnoreEnd
    }
}
