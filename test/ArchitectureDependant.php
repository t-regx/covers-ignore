<?php
namespace Test;

use Exception;

trait ArchitectureDependant
{
    use TestCaseConditional;

    public function markTestUnnecessaryOnWindows(): void
    {
        if (!$this->isUnixEnvironment()) {
            $this->markTestUnnecessary('Test is valuable only on 64-bit architecture');
        }
    }

    public function marTestUnnecessaryOnUnix(): void
    {
        if ($this->isUnixEnvironment()) {
            $this->markTestUnnecessary('Test is valuable only on 64-bit architecture');
        }
    }

    public function isUnixEnvironment(): bool
    {
        if (\PHP_EOL === "\n" && \DIRECTORY_SEPARATOR === "/") {
            return true;
        }
        if (\PHP_EOL === "\r\n" && \DIRECTORY_SEPARATOR === "\\") {
            return false;
        }
        throw new Exception();
    }
}
