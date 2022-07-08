<?php
namespace TRegx\CoversIgnore;

use PhpParser\Comment;
use PhpParser\Lexer\Emulative;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser\Php7;
use PhpParser\PrettyPrinter\Standard;

class TestFile
{
    public function __construct(private string $content)
    {
    }

    public function coversIgnored(): string
    {
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class extends NodeVisitorAbstract {
            public function leaveNode(Node $node)
            {
                if ($node instanceof Class_) {
                    $newComments = [];
                    foreach ($node->getComments() as $comment) {
                        if (str_contains($comment->getText(), '@covers')) {
                            $newComments[] = new Comment('');
                        } else {
                            $newComments[] = $comment;
                        }
                    }
                    $node->setAttribute('comments', $newComments);
                }
            }
        });
        $lexer = new Emulative([
            'phpVersion'     => Emulative::PHP_7_3,
            'usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'],
        ]);
        $parser = new Php7($lexer);
        $statements = $parser->parse($this->content);
        $printer = new Standard();
        return $printer->printFormatPreserving($traverser->traverse($statements), $statements, $lexer->getTokens());
    }
}
