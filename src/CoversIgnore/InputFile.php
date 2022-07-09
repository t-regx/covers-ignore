<?php
namespace TRegx\CoversIgnore;

class InputFile
{
    public function __construct(private Arguments $arguments, private string $directory)
    {
    }

    public function isDirectory(): bool
    {
        return \is_dir($this->source());
    }

    public function source(): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $this->arguments->filename();
    }
}
