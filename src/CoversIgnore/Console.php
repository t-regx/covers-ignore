<?php
namespace TRegx\CoversIgnore;

class Console
{
    public function notify(string $filename): void
    {
        echo "File cleaned $filename" . PHP_EOL;
    }

    public function summary(Statistic $statistic): void
    {
        echo "Checked: $statistic->all files. Updated $statistic->updated files. {$statistic->untouched()} files were already clean." . PHP_EOL;
    }
}
