<?php
namespace TRegx\CoversIgnore;

class Statistic
{
    public int $all = 0;
    public int $updated = 0;

    public function nextFile(): void
    {
        $this->all++;
    }

    public function nextFileUpdated(): void
    {
        $this->updated++;
    }

    public function untouched(): int
    {
        return $this->all - $this->updated;
    }
}
