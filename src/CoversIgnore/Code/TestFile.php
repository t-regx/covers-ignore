<?php
namespace TRegx\CoversIgnore\Code;

use PhpParser\Lexer;
use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\Parser\Php7;
use PhpParser\PrettyPrinter\Standard;
use TRegx\CoversIgnore\FileSystem\File;
use TRegx\CoversIgnore\Parser\ClassVisitor;
use TRegx\CoversIgnore\Parser\LeaveNode;
use TRegx\CoversIgnore\Parser\RemoveCommentNode;

class TestFile
{
    private NodeTraverser $traverser;
    private Lexer $lexer;
    private LeaveNode $leaveNode;
    private Parser $parser;

    public function __construct(private File $file)
    {
        $this->leaveNode = new RemoveCommentNode();
        $this->traverser = new NodeTraverser();
        $this->traverser->addVisitor(new ClassVisitor($this->leaveNode));
        $this->lexer = new Emulative([
            'phpVersion'     => Emulative::PHP_7_3,
            'usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'],
        ]);
        $this->parser = new Php7($this->lexer);
    }

    public function coversIgnored(): string
    {
        $oldStatements = $this->parser->parse($this->file->content());
        $newStatements = $this->traverser->traverse($oldStatements);
        return $this->prettySourceCode($newStatements, $oldStatements);
    }

    public function hasCovers(): bool
    {
        $this->traverser->traverse($this->parser->parse($this->file->content()));
        return $this->leaveNode->hasComment();
    }

    private function prettySourceCode(array $newStatements, array $oldStatements): string
    {
        $standardPrinter = new Standard();
        return $standardPrinter->printFormatPreserving($newStatements, $oldStatements, $this->lexer->getTokens());
    }
}
