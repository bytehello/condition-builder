<?php
namespace ByteHello\ConditionBuilder;
class Code
{
    protected $expr;

    public function __construct($expr)
    {
        $this->expr = $expr;
    }

    public function setExpr($expr)
    {
        $this->expr = $expr;
    }

    public function getExpr()
    {
        return $this->expr;
    }

    public function getCode()
    {
        $stmts = [$this->expr];
        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        return $prettyPrinter->prettyPrint($stmts);
    }
}