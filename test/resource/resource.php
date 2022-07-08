<?php
namespace Test\resource;

use TRegx\CoversIgnore\FileSystem\File;

function resource(string $resource): string
{
    return \file_get_contents(resource_path($resource));
}

function resource_file(string $resource): File
{
    return new File(resource_path($resource));
}

function resource_path(string $resource): string
{
    return join(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', $resource]);
}
