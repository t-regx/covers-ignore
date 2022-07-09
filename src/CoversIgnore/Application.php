<?php
namespace TRegx\CoversIgnore;

use TRegx\CoversIgnore\Code\TestFile;
use TRegx\CoversIgnore\FileSystem\Directory;
use TRegx\CoversIgnore\FileSystem\File;

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
        $this->runInput(new InputFile($arguments, $this->directory));
    }

    private function runInput(InputFile $input): void
    {
        if ($input->isDirectory()) {
            $this->runDirectory($input);
        } else {
            $this->runFile($input);
        }
    }

    private function runFile(InputFile $x): void
    {
        $file = new File($x->source());
        $testFile = new TestFile($file);
        if ($testFile->hasCovers()) {
            $file->write($testFile->coversIgnored());
        }
    }

    private function runDirectory(InputFile $inputFile): void
    {
        $stats = new Statistic();
        foreach (new Directory($inputFile->source()) as $file) {
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
}
