<?php
namespace TRegx\CoversIgnore\Parser;

use PhpParser\Node;

interface LeaveNode
{
    public function leaveNode(Node $node): bool;
}
