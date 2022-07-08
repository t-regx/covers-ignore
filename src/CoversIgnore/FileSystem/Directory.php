<?php
namespace TRegx\CoversIgnore\FileSystem;

use IteratorAggregate;

class Directory implements IteratorAggregate
{
    public function __construct(private string $filename)
    {
    }

    /**
     * @return iterable<File>
     */
    public function getIterator(): iterable
    {
        foreach ($this->recursiveFiles() as [$filename]) {
            yield new File($filename);
        }
    }

    private function recursiveFiles(): \RegexIterator
    {
        $children = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->filename));
        return new \RegexIterator($children, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
    }
}
