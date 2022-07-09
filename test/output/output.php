<?php
namespace Test\output;

use Exception;

function output(callable $execution): OutputString
{
    \ob_start();
    try {
        $execution();
        return new OutputString(\ob_get_clean());
    } catch (Exception $exception) {
        \ob_end_clean();
        throw $exception;
    }
}
