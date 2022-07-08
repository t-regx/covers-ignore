<?php
namespace TRegx\CoversIgnore;

use TRegx\CoversIgnore\Code\TestFile;
use TRegx\CoversIgnore\FileSystem\Directory;

class Application
{
    private Console $console;
    private string $directory;

    public function __construct(string $directory)
    {
        $this->console = new Console();
        $this->directory = $directory;
    }

    public function run(array $runtimeArguments): void
    {
        $this->runApp(new Arguments($runtimeArguments));
    }

    private function runApp(Arguments $arguments): void
    {
        $stats = new Statistic();
        foreach (new Directory($this->source($arguments)) as $file) {
            $stats->nextFile();
            $testFile = new TestFile($file);
            if ($testFile->hasCovers()) {
                $file->write($testFile->coversIgnored());
                $stats->nextFileUpdated();
                $this->console->notify($file->relativePath($this->directory));
            }
        }
        $this->console->summary($stats);
    }

    private function source(Arguments $arguments): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $arguments->filename();
    }
}
