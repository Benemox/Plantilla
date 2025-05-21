<?php

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonExtract extends FunctionNode
{
    private $jsonField;
    private $jsonPath;

    public function parse(Parser $parser): void
    {
        $this->jsonField = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->jsonPath = $parser->StringPrimary();
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            "JSON_UNQUOTE(JSON_EXTRACT(%s, %s))",
            $this->jsonField->dispatch($sqlWalker),
            $this->jsonPath->dispatch($sqlWalker)
        );
    }
}
