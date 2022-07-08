<?php
namespace TRegx\CoversIgnore;

class Arguments
{
    public function __construct(private array $runtimeArguments)
    {
        if (\count($runtimeArguments) !== 2) {
            throw new \Exception("Usage: covers-ignore [file|directory/]");
        }
    }

    public function filename(): string
    {
        return $this->runtimeArguments[1];
    }
}
