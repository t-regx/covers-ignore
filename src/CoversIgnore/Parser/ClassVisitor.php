<?php
namespace TRegx\CoversIgnore\Parser;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class ClassVisitor extends NodeVisitorAbstract
{
    public function __construct(private LeaveNode $leaveNode)
    {
    }

    public function leaveNode(Node $node): ?int
    {
        if ($node instanceof Class_) {
            if ($this->leaveNode->leaveNode($node)) {
                return null;
            }
            return NodeTraverser::STOP_TRAVERSAL;
        }
        return null;
    }
}
