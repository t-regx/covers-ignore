<?php
namespace Test\resource;

function resource(string $resource): string
{
    return join(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', $resource]);
}
