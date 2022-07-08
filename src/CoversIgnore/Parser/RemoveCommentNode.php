<?php
namespace TRegx\CoversIgnore\Parser;

use PhpParser\Comment;
use PhpParser\Node;

class RemoveCommentNode implements LeaveNode
{
    private bool $hasComment = false;

    public function leaveNode(Node $node): bool
    {
        $newComments = [];
        foreach ($node->getComments() as $comment) {
            if ($this->isCoversComment($comment)) {
                $newComments[] = new Comment('');
                $this->hasComment = true;
            } else {
                $newComments[] = $comment;
            }
        }
        $node->setAttribute('comments', $newComments);
        return true;
    }

    private function isCoversComment(Comment $comment): bool
    {
        return \str_contains($comment->getText(), '@covers');
    }

    public function hasComment(): bool
    {
        return $this->hasComment;
    }
}
